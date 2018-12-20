@extends('public.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="index/css/review.css">
@stop

@section('javascript')
    <script src="index/js/starrr.js"></script>
    <script src="index/js/review.js"></script>
@stop

@section('main')
    <section class="hs-section pb-200">
        <div class="container">
            <h5>Cảm ơn bạn đã sử dụng dịch vụ tại</h5>
            <h2 class="bold">Phan’s House - Old Quarter</h2>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6 mb-25">
                    <div class="review-image"
                         style="background-image: url('https://cdn.luxstay.com/rooms/15425/thumbnail/1538016022_46494611.jpg?w=250&fit=crop&v=147661' )"></div>
                </div>

                <div class="col-12 col-md-6 mb-25">
                    <div id="review-form" class="pb-50">
                        <form>
                            <h4 class="fs-24 bold black">Vui lòng giúp chúng tôi đánh giá homestay này</h4>
                            <p class="fs-14 grey-9">Click vào ngôi sao để đánh giá!</p>

                            <p class='starrr' id='star1'></p>
                            <p>
                                <span class='your-choice-was' style='display: none;'>Bạn đã đánh giá <span class='choice'></span> sao.</span>
                            </p>

                            <input style="display: none;" name="name" id="star_input">
                            <textarea placeholder="Hãy cho chúng tôi một vài nhận xét" rows="5"
                                      name="content"></textarea>
                            <button class="hs-btn hs-btn-110-38 hs-btn-green">GỬI</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
