@extends('public.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="index/css/contact_us.css">
@stop

@section('javascript')
@stop

@section('main')
    <section class="hs-section pb-200">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="contact-us-image"
                         style="background-image: url( {{asset('local/storage/app/public/index/image/contact_us.png')}} )"></div>
                </div>

                <div class="col-12 col-md-6">
                    <div id="contact-form" class="pb-50">
                        <form>
                            <h6 class="fs-24 bold black">Liên hệ với chúng tôi</h6>
                            <p class="fs-14 grey-9">Chúng tôi luôn sẵn sàng hỗ trợ dù bạn ở bất cứ nơi đâu!</p>
                            <input placeholder="Họ tên" name="name">
                            <input placeholder="Số điện thoại" name="phone">
                            <input placeholder="Email" name="email">
                            <textarea placeholder="Nội dung bạn muốn gửi" name="content"></textarea>
                            <button class="hs-btn hs-btn-110-38 hs-btn-green">GỬI</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
