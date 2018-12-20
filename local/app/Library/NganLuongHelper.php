<?php
/**
 * Created by PhpStorm.
 * User: balol
 * Date: 12/27/2017
 * Time: 3:27 PM
 */
namespace App\Library;
include_once "NL_Checkoutv3.php";

class NganLuongHelper
{
    static function createPaymentNganLuong($data){
        $url_api = env('URL_API');
        $merchant_id = env('MERCHANT_ID');
        $merchant_password = env('MERCHANT_PASS');
        $receiver_email = env('RECEIVER');

        $nlcheckout= new NL_CheckOutV3($merchant_id,$merchant_password,$receiver_email,$url_api);

        $total_amount=$data['price'];

        $array_items=array();
        $payment_method = $data['option_payment'];
        $bank_code = $data['bankcode'];
        $order_code = $data['book_code'];

        $payment_type = 1;
        $discount_amount = 0;
        $order_description="Thanh toán đặt homestay qua cổng thanh toán trực tuyến nganluong.vn";
        $tax_amount=0;
        $fee_shipping=0;
        $return_url = env('URL_REDIRECT').$data['id']."/3";
        $cancel_url = env('URL_CANCEL').$data['id']."/4";

        $buyer_fullname = $data['cus_name'];
        $buyer_email = $data['cus_email'];
        $buyer_mobile = $data['cus_phone'];
        $buyer_address = $data['cus_address'];

        if($payment_method !='' && $buyer_email !="" && $buyer_mobile !="" && $buyer_fullname !="" && filter_var( $buyer_email, FILTER_VALIDATE_EMAIL )  ){

            if($payment_method =="VISA"){
                $nl_result= $nlcheckout->VisaCheckout($order_code,$total_amount,$payment_type,$order_description,$tax_amount,
                    $fee_shipping,$discount_amount,$return_url,$cancel_url,$buyer_fullname,$buyer_email,$buyer_mobile,
                    $buyer_address,$array_items,$bank_code);

            }elseif($payment_method =="NL"){
                $nl_result= $nlcheckout->NLCheckout($order_code,$total_amount,$payment_type,$order_description,$tax_amount,
                    $fee_shipping,$discount_amount,$return_url,$cancel_url,$buyer_fullname,$buyer_email,$buyer_mobile,
                    $buyer_address,$array_items);

            }elseif($payment_method =="ATM_ONLINE" && $bank_code !='' ){
                $nl_result= $nlcheckout->BankCheckout($order_code,$total_amount,$bank_code,$payment_type,$order_description,$tax_amount,
                    $fee_shipping,$discount_amount,$return_url,$cancel_url,$buyer_fullname,$buyer_email,$buyer_mobile,
                    $buyer_address,$array_items) ;
            }
            elseif($payment_method =="NH_OFFLINE"){
                $nl_result= $nlcheckout->officeBankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
            }
            elseif($payment_method =="ATM_OFFLINE"){
                $nl_result= $nlcheckout->BankOfflineCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);

            }
            elseif($payment_method =="IB_ONLINE"){
                $nl_result= $nlcheckout->IBCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
            }
            elseif ($payment_method == "CREDIT_CARD_PREPAID") {

                $nl_result = $nlcheckout->PrepaidVisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items, $bank_code);
            }

            if ($nl_result->error_code =='00'){

                //Cập nhât order với token  $nl_result->token để sử dụng check hoàn thành sau này
                $data['url_nganluong'] = (string)$nl_result->checkout_url;
                return $data;
            }else{
                return [
                    'status' => 0,
                    'message' => $nl_result->error_message
                ];
            }

        }else{
            return ("Tạo kết nối thanh toán với nganluong.vn không thành công");
        }
    }
}