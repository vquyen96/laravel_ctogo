@extends('public.master')

@section('css')
<link rel="stylesheet" type="text/css" href="base/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="base/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css">
<link rel="stylesheet" href="base/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css">
<link rel="stylesheet" type="text/css" href="index/css/index.css">
@stop

@section('javascript')
<script type="text/javascript" src="base/js/bootstrap-datepicker.min.js"></script>
<script src="base/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9yWMAqS_gR49H1kcehbFpYq8V936OnBc&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    $.ajax({
        method: "get",
        url: "{{asset('ajax-blog')}}",
    }).done(function( data ) {
        $('.owl-carousel-5').html(data);

        var owl = $('.owl-carousel-5');
        owl.owlCarousel({
            loop:true,
            margin:10,
            autoplay:true,
            autoplayTimeout:2000,
            autoplayHoverPause:true,
			responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:false
                },
                600:{
                    items:2,
                    nav:false
                },
                1000:{
                    items:3,
                    nav:false,
                    loop:false
                }
            }
        });

        $('.owl-carousel-5 .slide-item').hover(function(){
            $(this).find('.hs-btn').toggleClass('hs-btn-green');
        });
    });
</script>
<script type="text/javascript" src="index/js/index.js"></script>
<script>
	function initAutocomplete() {
        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
    }

    $(document).ready(function(){
        @if($comments->count() > 0)
        	$('.comment{{$comments->first()->comment_id}}').show();
		@endif
    	@foreach($comments as $comment)
    	$('.click-{{$comment->comment_id}}').click(function(){
    		$('.text-4').hide();
    		$('.comment{{$comment->comment_id}}').fadeIn();
    	});
    	@endforeach
    });
</script>
@stop

@section('main')

<section class="section-1">
	<div class="owl-carousel owl-banner owl-theme">
		@foreach( unserialize( $banners ) as $banner)
		<div class="item" style="background-image: url(' {{asset('local/storage/app/upload/'.$banner)}} ')"></div>
		@endforeach
	</div>
</section>

<section class="section-2">
	<div class="container">
		<div class="row">
			<div class="search-form">
				<form method="get" action=" {{ asset('search') }} ">
					<div class="first-row">
						<div class="my-form">
							<label>Điểm đến</label>
							<div class="destination"><input id="pac-input" type="text" name="location" placeholder="Bạn muốn đến đâu"></div>
						</div>

						<div class="my-form input-daterange">
							<div class="date-input">
								<label>Ngày đi</label>
								<div class="calendar"><input autocomplete="off" type="text" name="start" placeholder="Ngày đi"></div>
							</div>
							<div class="date-input">
								<label>Ngày về</label>
								<div class="calendar"><input autocomplete="off" type="text" name="end" placeholder="Ngày về"></div>
							</div>
						</div>

						<div class="my-form my-group">
							<div class="my-item">
								<label>Số người</label>
								<select name="slot">
									@for($i = 1; $i<=20; $i++)
									<option value="{{ $i }}">{{ $i }}</option>
									@endfor
								</select>
							</div>

							<div class="my-item">
								<label class="transparent">Tìm</label>
								<button type="submit">TÌM</button>
							</div>
						</div>
					</div>

					<div class="second-row">
						<div class="check-form">
							<input class="checkbox" type="checkbox" name=""> Tôi đi công tác
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<section class="section-3">
	<div class="container">
		<div class="row">
			<h6 class="hs-heading-1">Homestay nổi bật</h6>
			{{-- <p class="section-3-p">Xem thêm nhiều homestay</p> --}}
		</div>

		<div class="row">
			<div class="owl-carousel owl-carousel-1">
				@foreach($hot_homestay as $homestay)
				<div class="slide-item">
					<a href="{{ asset('detail/'.$homestay->homestay_id) }}" class="slide-image" style="display:block; background-image: url({{ is_url_exist(env('HOST_URL').'/local/storage/app/image/resized-'.$homestay->homestay_image) ? env('HOST_URL').'/local/storage/app/image/resized-'.$homestay->homestay_image : $homestay->homestay_image}})">
						<span class="slide-where">{{$homestay->homestay_city}}</span>
						@if( $homestay->homestay_hot == 1 )
						<span class="slide-hot">Hot</span>
						@elseif( date_diff($homestay->created_at,new DateTime() )->format('%a') <= 7 )
						<span class="slide-new">New</span>
						@endif
					</a>
					<a href="{{ asset('detail/'.$homestay->homestay_id) }}" class="slide-name">{{$homestay->homestay_name}}</a>
					<div class="slide-price">giá từ: {{ number_format(getMin($homestay->bedroom,'bedroom_price')) }} Đ</div>
					<div class="slide-review">
						<span class="slide-score">{{ getAverage($homestay->comment,'comment_rate') }}</span>
						<a class="slide-grade">
							<span>
								@if( getAverage($homestay->comment,'comment_rate') == 0 )
								Chưa có đánh giá
								@elseif( getAverage($homestay->comment,'comment_rate') <= 2 )
								Rất không tốt
								@elseif( getAverage($homestay->comment,'comment_rate') <= 4 )
								Không tốt
								@elseif( getAverage($homestay->comment,'comment_rate') <= 6 )
								Bình thường
								@elseif( getAverage($homestay->comment,'comment_rate') <= 8 )
								Tốt
								@else
								Rất tốt
								@endif 

							</span>
							<span class="hs-small-text">{{ count($homestay->comment) }} đánh giá</span>
						</a>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</section>

<section class="section-4">
	<div class="container">
		<div class="row">
			<div class="container-4">
				<div class="green-block">“</div>
				@foreach($comments as $comment)
				<div class="text-4 center comment{{$comment->comment_id}}">
					<h6 class="hs-heading-1">{{$comment->homestay->homestay_name}}</h6>
					<p>

						<span class="fa fa-star @if($comment->comment_rate >= 1) checked @endif"></span>
						<span class="fa fa-star @if($comment->comment_rate >= 2) checked @endif"></span>
						<span class="fa fa-star @if($comment->comment_rate >= 3) checked @endif"></span>
						<span class="fa fa-star @if($comment->comment_rate >= 4) checked @endif"></span>
						<span class="fa fa-star @if($comment->comment_rate >= 5) checked @endif"></span>
					</p>
					<p>{{$comment->comment_content}}</p>
					<p class="bold uppercase">{{$comment->user->name}}</p>
				</div>
				@endforeach

				<div class="carousel-4">
					<div class="owl-carousel owl-carousel-4">
						@foreach($comments as $comment)
						<div class="slide-item-4">
							<div class="slide-image-4 click-{{$comment->comment_id}}" style="background-image: url({{ asset('local/storage/app/image/user-3/resized-'.$comment->user->avatar) }});"></div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section-5 hs-section">
	<div class="container">
		<div class="row">
			<h6 class="hs-heading-1">Blog</h6>
		</div>

		<div class="row">
			<div class="owl-carousel owl-carousel-5">
				{{--ajax blog here--}}
			</div>
		</div>
	</div>
</section>

<section class="section-6">
	<div class="container">
		<div class="row">
			<div class="partner partner-carousel owl-carousel">
				<div class="partner-img-container">
					<img class="partner-img" src="index/image/logo-mytour.png">
				</div>
				<div class="partner-img-container">
					<img class="partner-img" src="index/image/logo.png">
				</div>
				<div class="partner-img-container">
					<img class="partner-img" src="index/image/logo_vntrip.png">
				</div>
				<div class="partner-img-container">
					<img class="partner-img" src="index/image/Logo cgroup.png">
				</div>
			</div>
		</div>
	</div>
</section>

@stop