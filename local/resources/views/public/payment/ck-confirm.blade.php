@extends('public.user-master')

@section('css')
<link rel="stylesheet" type="text/css" href="payment/css/confirm.css">
<link rel="stylesheet" type="text/css" href="payment/css/book-info.css">
@stop

@section('javascript')
<script type="text/javascript" src="{{public_path('js/app.js')}}"></script>
<script language="javascript">
    var h = {{$time_del['h']}}; // Giờ
    var m = {{$time_del['m']}}; // Phút
	var s = {{$time_del['s']}}; // giây

    // var h = 0; // Giờ
    // var m = 0; // Phút
    // var s = 3; // giây

    var timeout = null; // Timeout

    window.onload = function start()
    {
        if (s === -1){
            m -= 1;
            s = 59;
        }
        if (m === -1){
            h -= 1;
            m = 59;
        }
        if (h === -1){
            window.location = "{{route('update_status',['book_id' => $book->book_id,'status' => 2])}}";
            clearTimeout(timeout);
            return false;
        }

        $('#h').html(h);
        $('#m').html(m);
        $('#s').html(s);

        timeout = setTimeout(function(){
            s--;
            start();
        }, 1000);

        setTimeout(function () {
			check_status({{$book->book_id}})
        },10000)
    };

	function check_status(id) {
        $.ajax({
            url: '/check_status_book/'+id,
            method: 'get',
            dataType: 'json',
        }).fail(function (ui, status) {
        }).done(function (data, status) {
      		if(data.status == 3){
      		    window.location = "{{asset('complete?status=3')}}";
			}else  if(data.status == 4){
                window.location = "{{asset('complete?status=4')}}";
			}
        });
    }
</script>
@stop

@section('main')
	@include('public.payment.navigation')

<section class="hs-section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h6 class="bold">Thanh toán chuyển khoản</h6>
			</div>
		</div>

		<div class="row">
			<div class="col-12 col-md-8 col-lg-8">
				<div class=" pb-200 confirm-box">
					<div>
						<i class="fas fa-exclamation-circle" style="color: #EFD176;"></i> Hướng dẫn thanh toán đã được Ctogo gửi vào mail của bạn
					</div>
					<div class="confirm-box-main">
						<div class="confirm-box-child">
							<div class="confirm-box-header">
								<span class="main-color">01.</span> Bạn vui lòng tiến hành thanh toán trước
							</div>
							<div class="confirm-box-body">
								<p class="bold">Hôm nay {{date("d/m/Y H:m",time() + 7200)}}</p>
								<p class="fs-14">Thời gian còn lại <span id="h"></span> tiếng &nbsp; <span id="m"></span> phút &nbsp; <span id="s"></span> giây</p>
								@if($url_payment != '')
									<p><span>Link thanh toán: </span><a target="_blank" href="{{$url_payment}}">Link thanh toán</a></p>
								@endif
							</div>
						</div>

						<div class="confirm-box-child">
							<div class="confirm-box-header">
								<span class="main-color">02.</span> Khách hàng vui lòng chuyển khoản đến STK sau:
							</div>

							<div class="confirm-box-body">
								<img src="{{ asset('local/storage/app/public/payment/image/BIDV.png') }}"> <span class="bold">NGÂN HÀNG TMCP ĐẦU TƯ VÀ PHÁT TRIỂN VIỆT NAM</span>
								<hr>
								<p class="fs-14">Số tài khoản: 12345667</p>
								<p class="fs-14">Chủ tài khoản: Đoàn Công Chung</p>
								<p class="fs-14">Nội dung thanh toán: Thanh toán đặt chỗ {{$book->code}}</p>
								<hr>
								<p class="fs-14">Số tiền cần thanh toán: <span class="bold">{{number_format($book->price)}}đ</span></p>
								<p class="italic fs-12"><i class="fas fa-exclamation-circle" style="color: #EFD176;"></i> Lưu ý: -Bạn cần thanh toán chính xác số tiền đặt phòng của mình</p>
								<p class="italic fs-12"><i class="fas fa-exclamation-circle" style="color: #EFD176;"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nếu thanh toán qua chuyển khoản bạn cần chụp lại ảnh gửi cho chúng tôi</p>
							</div>
						</div>

						<div class="confirm-box-child">
							<div class="confirm-box-header">
								<span class="main-color">03.</span> Sau khi thanh toán thành công chúng tôi sẽ gửi mail xác nhận thanh toán cho bạn
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12 col-md-4 col-lg-4">
				@include('public.payment.book-info_payment')
			</div>
		</div>
	</div>
</section>
@stop
