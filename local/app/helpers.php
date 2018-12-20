<?php

/**
     * Save an image in request and  a resized copy of it.
     *
     * @return image name;
     */

function saveSingleImage($input,$resized_size,$path){
    $max_size = $resized_size;
    $image = $input;

    $filename = 'hs_'.date('Y-m-d').'_'.round( microtime( true ) ).'.'.$image->extension();
    $image->storeAs($path,$filename);

    $image_info = getimagesize($image);
    $width_orig  = $image_info[0];
    $height_orig = $image_info[1];

    $ratio = $width_orig/$height_orig;
    if($ratio>=1){
        $width=$max_size;
        $height=$width/$ratio;
    }else{
        $height=$max_size;
        $width=$height*$ratio;
    }
    $destination_image = imagecreatetruecolor($width, $height);

    //copy original image to new blank image according to extension
    $type_org = $image->extension();
    switch ($type_org) {
        case 'jpeg':
        $orig_image = imagecreatefromjpeg($image);
        imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        imagejpeg($destination_image, 'local/storage/app/'.$path.'/resized-'.$filename);
        break;

        case 'jpg':
        $orig_image = imagecreatefromjpeg($image);
        imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        imagejpeg($destination_image, 'local/storage/app/'.$path.'/resized-'.$filename);
        break;

        case 'png':
        $orig_image = imagecreatefrompng($image);
        imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        imagepng($destination_image, 'local/storage/app/'.$path.'/resized-'.$filename);
        break;

        case 'gif':
        $orig_image = imagecreatefromgif($image);
        imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        imagegif($destination_image, 'local/storage/app/'.$path.'/resized-'.$filename);
        break;
    }

    return $filename;
}

/**
     * Save all images in request and resized copies of them.
     *
     * @return implode('|' , 'all images with new names');
     */

function saveImage($input,$resized_size,$path){
    $imgArr = [];
    $max_size = $resized_size;
    foreach ($input as $image) {
        $filename = 'hs_'.date("Y-m-d").'_'.round( microtime( true ) ).'.'.$image->extension();
        $image->storeAs($path,$filename);
        $imgArr[] = $filename;

        $image_info = getimagesize($image);
        $width_orig  = $image_info[0];
        $height_orig = $image_info[1];

        $ratio = $width_orig/$height_orig;
        if($ratio>=1){
            $width=$max_size;
            $height=$width/$ratio;
        }else{
            $height=$max_size;
            $width=$height*$ratio;
        }
        $destination_image = imagecreatetruecolor($width, $height);

        $type_org = $image->extension();
        switch ($type_org) {
            case 'jpeg':
            $orig_image = imagecreatefromjpeg($image);
            imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
            imagejpeg($destination_image, 'local/storage/app/'.$path.'/resized-'.$filename);
            break;

            case 'jpg':
            $orig_image = imagecreatefromjpeg($image);
            imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
            imagejpeg($destination_image, 'local/storage/app/'.$path.'/resized-'.$filename);
            break;

            case 'png':
            $orig_image = imagecreatefrompng($image);
            imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
            imagepng($destination_image, 'local/storage/app/'.$path.'/resized-'.$filename);
            break;

            case 'gif':
            $orig_image = imagecreatefromgif($image);
            imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
            imagegif($destination_image, 'local/storage/app/'.$path.'/resized-'.$filename);
            break;
        }
    }
    return implode('|',$imgArr);
}

function getMax($input,$a){
    $max = '';
    foreach($input as $in){
        if($max < $in->$a){
            $max = $in->$a;
        }
    }
    return $max;
}

function getMin($input,$a){
    $min = $input->first()->$a;
    foreach($input as $in){
        if($min > $in->$a){
            $min = $in->$a;
        }
    }
    return $min;
}

function getAverage($input,$a){
    $total = 0;
    if (count($input) > 0) {
        foreach($input as $in){
            $total += $in->$a;
        }
        return round( $total/count($input), 1);
    }
    return '-';
}

function cut_string($text, $length)
{
    if(strlen($text) > $length) {
        $text = $text.' ';
        $text = substr($text, 0, strpos($text, ' ', $length)).'...';
    }
    return $text;
}

function convertAlias($cs){
    $vietnamese=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ",
        "è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ",
        "ì","í","ị","ỉ","ĩ",
        "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ",
        "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
        "ỳ","ý","ỵ","ỷ","ỹ",
        "đ",
        "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ",
        "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
        "Ì","Í","Ị","Ỉ","Ĩ",
        "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
        "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
        "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
        "Đ");
    $latin=array("a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a",
        "e","e","e","e","e","e","e","e","e","e","e",
        "i","i","i","i","i",
        "o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o",
        "u","u","u","u","u","u","u","u","u","u","u",
        "y","y","y","y","y",
        "d",
        "A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A",
        "E","E","E","E","E","E","E","E","E","E","E",
        "I","I","I","I","I",
        "O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O",
        "U","U","U","U","U","U","U","U","U","U","U",
        "Y","Y","Y","Y","Y",
        "D");
    $csLatin= str_replace($vietnamese,$latin,$cs);
    return $csLatin;
}

function getStatusBookStr($status){
    $str = '';
    $title = '';
    $class = '';
    switch ($status){
        case 1 : $str = 'Đợi thanh toán';$title = '';$class = 'btn-warning';break;
        case 2 : $str = 'Hủy';$title = 'Phòng bị hủy do quá thời hạn thanh toán';$class = 'btn-danger';break;
        case 3 : $str = 'Hoàn thành';$title = '';$class = 'btn-success';break;
        case 4 : $str = 'Hủy';$title = 'Do homestay hủy';$class = 'btn-danger';break;
    }
    return [
        'str' => $str,
        'title' => $title,
        'class' => $class
    ];
}

function get_actor($type){
    $str = '';
    switch ($type){
        case 1 : $str = 'Hệ thống ';break;
        case 2 : $str = 'Homestay ';break;
        case 3 : $str = 'Khách hàng ';break;
    }
    return $str;
}

function is_url_exist($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
        $status = true;
    }else{
        $status = false;
    }
    curl_close($ch);
    return $status;
}

function generateCode($model)
{
    $unique_code = false;

    while(!$unique_code) {
        $min = 10000000;
        $max = 99999999;

        $new_code = rand($min,$max);

        $model_data = \Illuminate\Support\Facades\DB::table($model)->where('code',$new_code)->first();

        if(!$model_data) {
            $unique_code = true;
        }
    }

    return $new_code;
}

function getSocial($type){
    $str = "Nguồn web";
    switch ($type){
        case 1: $str = "Facebook";break;
        case 2: $str = "Google";break;
    }

    return $str;
}