@extends('public.master')

@section('css')
<link rel="stylesheet" type="text/css" href="base/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" type="text/css" href="search-result/css/nouislider.min.css">
<link rel="stylesheet" type="text/css" href="search-result/css/search-result.css">
@stop

@section('javascript')
<script type="text/javascript" src="base/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="search-result/js/nouislider.min.js"></script>
<script type="text/javascript" src="search-result/js/wNumb.js"></script>
<script type="text/javascript" src="search-result/js/search-result.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9yWMAqS_gR49H1kcehbFpYq8V936OnBc&libraries=places&callback=initAutocomplete"
async defer></script>
<script >
	function search(page){
        $('#homestay-list').addClass('loader');

	    if( page == null ) page = 1;

		var form_data = $('#facility_form').serialize() + '&' + $('#main-form').serialize() + '&page=' + page;
		$.ajax({
			type: "POST",
			url: '{{ asset('search-ajax') }}',
			data: form_data,
			// dataType: "json",
		}).done( function(result){
			$('#homestay-list').html(result);
            $('#homestay-list').removeClass('loader');
		});
	}

	$(document).on('click','a.myPagination:not(.active):not(.disabled)',function(){
	    var page = $(this)[0].getAttribute("data-page");
		search( page );
        $("html, body").animate({scrollTop: $('#homestay-list').offset().top}, 500);
	});

	function initAutocomplete() {
        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
    }
</script>
@stop

@section('main')
<section class="section-1">
	<div class="container">
		<div class="row">
			<div class="form-container">
				<h6 class="center white mt-4 fs-24">Homestay tại {{ Request::get('location') ?? 'Việt Nam' }}</h6>
				<div class="search-form">
					<form id="main-form" method="get" action=" {{ asset('search') }} ">
						<div class="first-row">
							<div class="my-form">
								<label>Điểm đến</label>
								<div class="destination"><input id="pac-input" type="text" name="location" placeholder="Bạn muốn đến đâu" value="{{ Request::get('location') ?? '' }}"></div>
							</div>

							<div class="my-form input-daterange">
								<div class="date-input">
									<label>Ngày đi</label>
									<div class="calendar"><input autocomplete="off" type="text" name="start" placeholder="Ngày đi" value="{{ Request::get('start') ?? '' }}"></div>
								</div>
								<div class="date-input">
									<label>Ngày về</label>
									<div class="calendar"><input autocomplete="off" type="text" name="end" placeholder="Ngày về" value="{{ Request::get('end') ?? '' }}"></div>
								</div>
							</div>

							<div class="my-form my-group">
								<div class="my-item">
									<label>Số người</label>
									<select name="slot">
										@for($i = 1; $i<=20; $i++)
										<option @if( Request::get('slot') == $i ) selected="" @endif value="{{ $i }}">{{ $i }}</option>
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
	</div>
</section>

<section class="section-2 hs-section pb-200">
	<div class="container">
		<div class="row">
			<form id="facility_form" class="col-12 col-md-4 col-lg-4" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="my-form">
					<label>Giá</label>
					<div id="price"></div>
					<input onchange="search()" id="price-from" name="price_from">
					<input onchange="search()" id="price-to" name="price_to">
				</div>
				<div class="my-form">
					<label>Số phòng ngủ</label>
					<select onchange="search()" name="number_of_bedroom">
						@for($i=1;$i<=10;$i++)
						<option value="{{$i}}">{{$i}}</option>
						@endfor
					</select>
				</div>

				<hr>

				<div class="my-form col-flex">
					<label>Phân loại</label>
					<div><input onchange="search()" type="checkbox" name="homestay_type[]" value="1"> Dormitary</div>
					<div><input onchange="search()" type="checkbox" name="homestay_type[]" value="2"> Homestay</div>
					<div><input onchange="search()" type="checkbox" name="homestay_type[]" value="3"> Nhà riêng</div>
				</div>

				<hr>

				<div class="my-form col-flex">
					<label>Tiện ích giải trí</label>
					@foreach($facilities as $facility)
					<div><input onchange="search()" type="checkbox" name="facility[]" value="{{ $facility->facility_id }}"> {{ $facility->facility_name }}</div>
					@endforeach
				</div>

				<hr>

				<div class="my-form col-flex">
					<label>Tiện ích phòng</label>
					@foreach($bedroom_facilities as $bedroom_facility)
					<div><input onchange="search()" type="checkbox" name="bedroom_facility[]" value=" {{ $bedroom_facility->bedroom_facility_id }} "> {{ $bedroom_facility->bedroom_facility_name }}</div>
					@endforeach
				</div>
			</form>

			<div id="homestay-list" class="col-12 col-md-8 col-lg-8">
				{{--ajax here--}}
			</div>
		</div>
	</div>
</section>
@stop