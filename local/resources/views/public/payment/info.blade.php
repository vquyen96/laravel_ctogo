@extends('public.user-master')

@section('css')
<link rel="stylesheet" type="text/css" href="payment/css/payment.css">
<link rel="stylesheet" type="text/css" href="payment/css/book-info.css">

@stop

@section('javascript')
	<script>
        $("#info_payment").validate({
            ignore: [],
            rules: {
                'fullname': {
                    required: true
                },
                'email': {
                    required: true,
                    email : true
                },
                'phone': {
                    required: true,
                    phone : true
                }
            },
            messages: {
                'fullname': {
                    required: "Vui lòng nhập họ và tên"
                },
                'email': {
                    required: "Vui lòng nhập email",
					email : "Email không đúng định dạng"
                },
                'phone': {
                    required: "Vui lòng nhập số điện thoại",
					phone : "Số điện thoại không đúng định dạng"
                }
            }
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
			</div>
		</div>

		<div class="row">
			<div class="col-12 col-md-8 col-lg-8">
				<div class="book-box">
					<form id="info_payment" action="{{route('action_info_payment')}}" method="get">
						<div class="row">
							<div class="col-12 col-md-6 col-lg-6">
								<div class="form-item-2">
									<label>Tên người liên hệ: <span class="text-danger">*</span></label>
									<input type="text" name="fullname" value="{{Auth::user()->name}}" placeholder="Họ và tên">
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-6">
								<div class="form-item-2">
									<label>Email:<span class="text-danger">*</span></label>
									<input type="text" name="email" value="{{Auth::user()->email}}" placeholder="email@example.com">
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-6">
								<div class="form-item-2">
									<label>Số di động:<span class="text-danger">*</span></label>
									<input type="text" name="phone" value="{{Auth::user()->phone}}" placeholder="+84123456789">
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-6">
								<div class="form-item-2">
									<label>Quốc gia:</label>
									<input type="text" name="country" value="">
								</div>
							</div>
						</div>

						<div class="form-item-2 right-bottom">
							<button style="cursor: pointer" type="submit">Tiếp tục</button>
						</div>
					</form>
				</div>
			</div>

			<div class="col-12 col-md-4 col-lg-4">
				@include('public.payment.book-info')
			</div>
		</div>
	</div>
</section>
@stop