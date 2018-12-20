@extends('public.user-master')

@section('css')
<link rel="stylesheet" type="text/css" href="payment/css/payment.css">
@stop

@section('javascript')

@stop

@section('main')
<section class="hs-section mb-50">
	<div class="container">
		<div class="row">
			<div class="complete-container">
				<div class="complete-center">
					<img src="{{ asset('local/storage/app/public/payment/image/checked.png') }}">
					<p>Cảm ơn bạn đã đặt homestay này tại Ctogo. Bộ phận chăm sóc khách hàng sẽ gọi điện lại xác nhận cho bạn khi thanh toán thành công</p>
				</div>

				@if (session('warning'))
					<div class="alert alert-warning">
						<p>{{ session('warning') }}</p>
					</div>
				@endif

				@if (session('success'))
					<div class="alert alert-success">
						<p>{{ session('success') }}</p>
					</div>
				@endif

				@if (session('danger'))
					<div class="alert alert-danger">
						<p>{{ session('danger') }}</p>
					</div>
				@endif

				@if (isset($success))
					<div class="alert alert-success">
						<p>{{ $success }}</p>
					</div>
				@endif
				@if (isset($danger))
					<div class="alert alert-danger">
						<p>{{ $danger }}</p>
					</div>
				@endif
			</div>
		</div>
	</div>
</section>
@stop