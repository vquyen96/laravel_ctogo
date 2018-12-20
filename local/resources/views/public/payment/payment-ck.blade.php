<form class="book-box book-box-body pb-200" action="{{route('action_payment_method')}}" method="post">
	{{ csrf_field() }}
	<h6 class="fs-16 bold">Chuyển khoản</h6>
	<p class="semi-bold fs-14">Bạn có thể chuyển khoản tại quầy giao dịch, qua Internet Banking hoặc ATM</p>
	<p class="semi-bold fs-14">Lưu ý: Phí chuyển khoản sẽ do bạn trả</p>

	<h6 class="fs-16 bold">Chọn ngân hàng:</h6>

	<div class="bank-container">
		<div class="bank-item">
			<div class="bank-input">
				<input value="bidv" type="radio" checked="checked" name="bankcode">
				<span class="checkmark"></span>
			</div>
			<div class="bank-image" style="background-image: url({{ asset('local/storage/app/public/payment/image/BIDV.png') }});"></div>
		</div>

		<div class="bank-item">
			<div class="bank-input">
				<input value="bidv" type="radio" name="bankcode">
				<span class="checkmark"></span>
			</div>
			<div class="bank-image" style="background-image: url({{ asset('local/storage/app/public/payment/image/BIDV.png') }});"></div>
		</div>

		<div class="bank-item">
			<div class="bank-input">
				<input value="bidv" type="radio" name="bankcode">
				<span class="checkmark"></span>
			</div>
			<div class="bank-image" style="background-image: url({{ asset('local/storage/app/public/payment/image/BIDV.png') }});"></div>
		</div>

		<div class="bank-item">
			<div class="bank-input">
				<input value="bidv" type="radio" name="bankcode">
				<span class="checkmark"></span>
			</div>
			<div class="bank-image" style="background-image: url({{ asset('local/storage/app/public/payment/image/BIDV.png') }});"></div>
		</div>

		<div class="bank-item">
			<div class="bank-input">
				<input value="bidv" type="radio" name="bankcode">
				<span class="checkmark"></span>
			</div>
			<div class="bank-image" style="background-image: url({{ asset('local/storage/app/public/payment/image/BIDV.png') }});"></div>
		</div>

		<div class="bank-item">
			<div class="bank-input">
				<input value="bidv" type="radio" name="bankcode">
				<span class="checkmark"></span>
			</div>
			<div class="bank-image" style="background-image: url({{ asset('local/storage/app/public/payment/image/BIDV.png') }});"></div>
		</div>
	</div>
	<input name="method_payment" value="3" class="d-none">
	<button type="submit" class="hs-btn hs-btn-green hs-btn-lg payment-btn">Thanh toán</button>
</form>