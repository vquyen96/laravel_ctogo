<div class="book-box">
	<div class="book-box-header">
		Thông tin homestay
	</div>
	<div class="book-box-body">
		<div class="book-homestay">
			<div class="book-image" style="background-image: url({{env('HOST_URL').'/local/storage/app/image/'.$homestay->homestay_image}});"></div>
			<div class="book-homestay-info">
				<div class="book-homestay-code">Mã đặt chỗ: {{$book->code}}</div>
				<div class="book-homestay-name">{{$homestay->homestay_name}}</div>
				<div class="book-homestay-address"><i class="fas fa-map-marker-alt"></i> {{$homestay->homestay_location}}</div>
			</div>
		</div>
		<div class="book-info">
			<div class="book-info-row">
				<span class="book-info-left">Số đêm nghỉ</span>
				<span class="book-info-right">{{$number_night}} đêm</span>
			</div>

			<div class="book-info-row">
				<span class="book-info-left">Ngày đến</span>
				<span class="book-info-right">{{$book->book_from}}</span>
			</div>

			<div class="book-info-row">
				<span class="book-info-left">Ngày đi</span>
				<span class="book-info-right">{{$book->book_to}}</span>
			</div>

			<div class="book-info-row">
				<span class="book-info-left">Số người</span>
				<span class="book-info-right">{{$book->book_slot}}</span>
			</div>
			<hr>
			<div class="book-info-row">
				<span class="book-info-left">{{number_format($bedroom->bedroom_price)}}đ x 1 đêm</span>
			</div>
			<hr>
			<div class="book-info-row">
				<span class="book-info-discount">Giảm (-20%)</span>
			</div>
			<div class="book-info-row-last">
				<span class="book-info-left">TỔNG</span>
				<span class="book-info-right">{{number_format($book->price)}}</span>
			</div>
		</div>
	</div>
</div>