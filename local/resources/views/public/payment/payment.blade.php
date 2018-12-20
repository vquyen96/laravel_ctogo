@extends('public.user-master')

@section('css')
<link rel="stylesheet" type="text/css" href="payment/css/payment.css">
<link rel="stylesheet" type="text/css" href="payment/css/book-info.css">
@stop

@section('javascript')
<script type="text/javascript" src="payment/js/payment.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script language="javascript">
    $('input[name="option_payment"]').bind('click', function() {
        $('.list-content li').removeClass('active');
        $(this).parent().parent('li').addClass('active');
    });

    $("#ngan_luong").on('click',function () {
        if($(this).is(':checked')){
            $("#nlpayment").show();
        }else $("#nlpayment").hide();
    });
</script>
@stop

@section('main')

	@include('public.payment.navigation')

<section class="hs-section mb-50">
	<div class="container">
		<div class="row mb-4">
			<div class="col-12">
				<h6 class="bold">Thông tin liên hệ/Thông tin khách</h6>	
				<p class="semi-bold"><span class="main-color"><i class="fas fa-exclamation"></i> Lưu ý:</span> Khi bạn thanh toán bằng Thẻ tín dụng, Thanh toán trực tuyến, Chuyển khoản hoặc thanh toán tại cửa hàng thì bạn sẽ nhận được ưu đãi 20% từ Ctogo.</p>
			</div>
		</div>

		<div class="row">
			<div class="col-12 col-md-8 col-lg-8">
				<div>
					<nav>
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
							<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Thẻ tín dụng</a>
							<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Thanh toán trực tuyến</a>
							<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Chuyển khoản</a>
						</div>
					</nav>
					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

						</div>
						<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
							@include('public.payment.payment-ol')
						</div>
						<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
							@include('public.payment.payment-ck')
						</div>
					</div>
					<div class="fs-14 semi-bold mt-4">
						Khi bạn nhấn vào nút thanh toán là bạn công nhận mình đã đọc và đồng ý với các Điều khoản & Điều kiện và Chính sách quyền riêng tư của Ctogo
					</div>
				</div>
			</div>

			<div class="col-12 col-md-4 col-lg-4">
				@include('public.payment.book-info')
			</div>
		</div>
	</div>
</section>
@stop