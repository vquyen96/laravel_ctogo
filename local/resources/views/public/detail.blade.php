@extends('public.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="base/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="detail/css/ninja.css">
    <link rel="stylesheet" type="text/css" href="detail/css/detail.css">
    <link rel="stylesheet" href="base/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="base/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css">
@stop

@section('javascript')
    <script type="text/javascript" src="base/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="detail/js/ninja.js"></script>
    <script type="text/javascript" src="detail/js/detail.js"></script>
    <script src="base/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
    <script async="" defer=""
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9yWMAqS_gR49H1kcehbFpYq8V936OnBc&amp;callback=initMap">
    </script>
    <script type="text/javascript">
        $.fn.serializeFormJSON = function () {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function () {
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        }

        //ajax check
        function check() {
            var form_data = $('#bedroom-check').serialize();
            var form_json = $('#bedroom-check').serializeFormJSON();
            if (form_json.start != "" && form_json.end != "") {
                $.ajax({
                    type: "POST",
                    url: '{{ asset('check-ajax') }}',
                    data: form_data
                }).done(function (result) {
                            @foreach($homestay->bedroom as $bedroom)
                    var avail = '.room_' + '{{$bedroom->bedroom_id}}' + ' .available-btn';
                    var book = '.room_' + '{{$bedroom->bedroom_id}}' + ' .book-btn';
                    $(avail).show();
                    if (result.indexOf({{$bedroom->bedroom_id}}) >= 0) {
                        $(book).show();
                        $(avail + ' .avail').show();
                        $(avail + ' .not-avail').hide();
                    } else {
                        $(book).hide();
                        $(avail + ' .avail').hide();
                        $(avail + ' .not-avail').show();
                    }

                    @endforeach
                });
            }
        }

        //datepicker
        $('.input-daterange').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            startDate: new Date()
        });

        var getDaysArray = function (start, end) {
            var arr = [];
            var b;
            ds = new Date(start);
            ds.setDate(ds.getDate() + 1);
            de = new Date(end);
            de.setDate(de.getDate() + 1);
            for (ds; ds <= de; ds.setDate(ds.getDate() + 1)) {
                arr.push(new Date(ds));
            }
            return arr;
        };

        @foreach($homestay->bedroom as $bedroom)
        $('#room-calendar{{$bedroom->bedroom_id}}').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            startDate: new Date(),
            datesDisabled: [
                @foreach( $bedroom->book as $book )
                ...getDaysArray('{{$book->book_from}}', '{{$book->book_to}}'),
                @endforeach
            ]
        });
        @endforeach

        //google map
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng{{$homestay->homestay_latlng ?? ''}},
                zoom: 17,
                styles: [
                    {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
                    {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
                    {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
                    {
                        featureType: 'administrative.locality',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#999999'}]
                    },
                    {
                        featureType: 'poi',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#d59563'}]
                    },
                    {
                        featureType: 'poi.park',
                        elementType: 'geometry',
                        stylers: [{color: '#263c3f'}]
                    },
                    {
                        featureType: 'poi.park',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#6b9a76'}]
                    },
                    {
                        featureType: 'road',
                        elementType: 'geometry',
                        stylers: [{color: '#333333'}]
                    },
                    {
                        featureType: 'road',
                        elementType: 'geometry.stroke',
                        stylers: [{color: '#333333'}]
                    },
                    {
                        featureType: 'road',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#999999'}]
                    },
                    {
                        featureType: 'road.highway',
                        elementType: 'geometry',
                        stylers: [{color: '#333333'}]
                    },
                    {
                        featureType: 'road.highway',
                        elementType: 'geometry.stroke',
                        stylers: [{color: '#1f2835'}]
                    },
                    {
                        featureType: 'road.highway',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#f3d19c'}]
                    },
                    {
                        featureType: 'transit',
                        elementType: 'geometry',
                        stylers: [{color: '#2f3948'}]
                    },
                    {
                        featureType: 'transit.station',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#d59563'}]
                    },
                    {
                        featureType: 'water',
                        elementType: 'geometry',
                        stylers: [{color: '#17263c'}]
                    },
                    {
                        featureType: 'water',
                        elementType: 'labels.text.fill',
                        stylers: [{color: '#515c6d'}]
                    },
                    {
                        featureType: 'water',
                        elementType: 'labels.text.stroke',
                        stylers: [{color: '#17263c'}]
                    }
                ]
            });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng{{$homestay->homestay_latlng}},
                map: map
            });

            var cityCircle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: new google.maps.LatLng{{$homestay->homestay_latlng}},
                radius: 100
            });
        }

        //other effects
        $(document).ready(function () {

            var $cache = $('.host-info');
            var x = $cache.offset().top;
            var z = $cache.outerHeight();

            function fixDiv() {
                if ($(window).scrollTop() > x && $(window).scrollTop() <= ($('.section-4').offset().top - z - 33)) {
                    $cache.css({
                        'position': 'fixed',
                        'top': '10px',
                        'bottom': 'auto'
                    });
                }
                else if ($(window).scrollTop() > ($('.section-4').offset().top - z - 33)) {
                    $cache.css({
                        'position': 'absolute',
                        'top': 'auto',
                        'bottom': '0px'
                    });
                }
                else {
                    $cache.css({
                        'position': 'relative',
                        'top': 'auto',
                        'bottom': 'auto'
                    });
                }
            }

            $(window).scroll(fixDiv);
            fixDiv();

            $('.collapse').on('shown.bs.collapse', function () {
                $(this).prev('.see-detail').html('Ẩn chi tiết');
            });
            $('.collapse').on('hidden.bs.collapse', function () {
                $(this).prev('.see-detail').html('Xem lịch và chi tiết đặt phòng');
            });
        });

        //ninja slider
        function lightbox(idx) {
            var ninjaSldr = document.getElementById("ninja-slider");
            ninjaSldr.parentNode.style.display = "block";

            nslider.init(idx);

            var fsBtn = document.getElementById("fsBtn");
            fsBtn.click();
        }

        function fsIconClick(isFullscreen, ninjaSldr) {
            if (isFullscreen) {
                ninjaSldr.parentNode.style.display = "none";
            }
        }
    </script>
@stop

@section('main')
    <section class="section-1"
             style="background-image: url({{ is_url_exist(env('HOST_URL').'/local/storage/app/image/resized-'.$homestay->homestay_image) ? env('HOST_URL').'/local/storage/app/image/resized-'.$homestay->homestay_image : $homestay->homestay_image}})">
        <div class="container">
            <div class="row">
                <h1 class="fs-24 bold white center uppercase h1-sec1">{{$homestay->homestay_name}}</h1>
            </div>
        </div>
    </section>

    <section class="section-2">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="slide-container">
                        <div class="owl-carousel owl-carousel-1 owl-theme">
                            @php $i =  0; @endphp
                            @foreach($homestay->homestayimage as $homestayimage)
                                <div class="slide-item-1" onclick="lightbox({{$i}})"
                                     style="background-image: url({{ is_url_exist(env('HOST_URL').'/local/storage/app/image/resized-'.$homestayimage->homestay_image_img) ? env('HOST_URL').'/local/storage/app/image/resized-'.$homestayimage->homestay_image_img : $homestayimage->homestay_image_img}})">
                                </div>
                                @php $i++; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>X
    </section>

    <div style="display:none;">
        <div id="ninja-slider">
            <div class="slider-inner">
                <ul>
                    @foreach($homestay->homestayimage as $homestayimage)
                        <li>
                            <a class="ns-img"
                               href="{{ is_url_exist(env('HOST_URL').'/local/storage/app/image/'.$homestayimage->homestay_image_img) ? env('HOST_URL').'/local/storage/app/image/'.$homestayimage->homestay_image_img : $homestayimage->homestay_image_img}}"></a>
                            {{-- <div class="caption">
                                <h3>Dummy Caption 1</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus accumsan purus.</p>
                            </div> --}}
                        </li>
                    @endforeach
                </ul>
                <div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
            </div>
        </div>
    </div>



    <section class="section-3">
        <div class="container">
            <div class="row input-daterange">
                <div class="col-12 col-md-8 col-lg-8">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-10">
                            <h6 class="fs-18 bold">Mô tả</h6>
                            <div class="homestay_about">
                                {!!$homestay->homestay_about!!}
                            </div>

                            <h6 class="fs-18 bold">Dịch vụ</h6>
                            <ul class="service">
                                @foreach( explode(',',$homestay->homestay_facility) as $facility)
                                    <li>
                                        <i class="fas fa-check main-color"></i> {{ $facilities->find($facility)->facility_name ?? "Dịch vụ chưa được thống kê"}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <h6 class="fs-18 bold">Phòng còn trống</h6>
                    <form class="row" id="bedroom-check" method="post" action="{{route('add_order')}}">
                        {{csrf_field()}}
                        <input type="" name="homestay_id" style="display: none;" value="{{$homestay->homestay_id}}">
                        <div class="col-12 col-md-6 col-lg-5">
                            <div class="my-form">
                                <label class="fs-14 bold">Ngày nhận phòng</label>
                                <div class="calendar"><input
                                            value="{{isset($data_search['start']) ? $data_search['start'] : ''}}"
                                            autocomplete="off" onchange="check()"
                                            data-provide="datepicker" type="text" name="start"
                                            placeholder="Ngày đến"></div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-5">
                            <div class="my-form">
                                <label class="fs-14 bold">Ngày trả phòng</label>
                                <div class="calendar">
                                    <input value="{{isset($data_search['end']) ? $data_search['end'] : ''}}"
                                           autocomplete="off" onchange="check()" data-provide="datepicker" type="text"
                                           name="end" placeholder="Ngày đi">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-2">
                            <div class="my-form">
                                <label class="fs-14 bold">Số người</label>
                                <select class="select-box" name="slot" onchange="check()">
                                    @for($i=1;$i<=20;$i++)
                                        <option {{(isset($data_search['slot']) && $data_search['slot'] == $i) ? 'selected' : ''}}  value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </form>

                    @foreach($homestay->bedroom as $bedroom)
                        <div class="room-item room_{{$bedroom->bedroom_id}}">
                            <a class="room-image" onclick="lightbox2()"
                               style="background-image: url( {{ file_exists( env('HOST_URL').'/local/storage/app/image/'.$bedroom->bedroomimage->first()->bedroom_image_img ) ? env('HOST_URL').'/local/storage/app/image/'.$bedroom->bedroomimage->first()->bedroom_image_img : $bedroom->bedroomimage->first()->bedroom_image_img }} );"></a>
                            <div class="room-content">
                                <h5>{{$bedroom->bedroom_name}}</h5>
                                <ul class="room-service">
                                    <li><i class="fas fa-bath"></i> @if($bedroom->bedroom_bath == 1) Khép kín @else
                                            Chung @endif</li>
                                    <li><i class="fas fa-user"></i> {{ $bedroom->bedroom_slot }}</li>
                                    <li><i class="fas fa-bed"></i> 2</li>
                                </ul>
                                <p class="fs-14 bold uppercase">Giá: {{ number_format($bedroom->bedroom_price) }}
                                    Đ/ĐÊM</p>

                                <div class="available-btn">
                                    <p class="grey-9 fs-14 mb-1">Tình trạng:</p>
                                    <a class="avail">Còn phòng</a>
                                    <a class="not-avail">Hết phòng</a>
                                </div>

                                <a style="cursor: pointer"
                                   onclick="add_order('{{$bedroom->bedroom_id}}','{{$bedroom->bedroom_price}}','{{$homestay->homestay_id}}')"
                                   class="book-btn hs-btn-90-30 hs-btn-green">Đặt phòng</a>
                            </div>
                            <a class="see-detail" data-toggle="collapse" href="#collapseExample{{$bedroom->bedroom_id}}"
                               role="button" aria-expanded="false" aria-controls="collapseExample">Xem lịch và chi tiết
                                đặt phòng</a>
                            <div class="collapse" id="collapseExample{{$bedroom->bedroom_id}}">
                                <div class="room-detail">
                                    <div class="mb-4">
                                        {!! $bedroom->bedroom_description !!}
                                    </div>
                                    @if($bedroom->bedroom_facility)
                                        <ul class="mb-4">
                                            @foreach(explode(',',$bedroom->bedroom_facility) as $facility)
                                                <li>
                                                    <i class="fas fa-check main-color"></i> {{$bedroom_facilities->find($facility)->bedroom_facility_name}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <p class="fs-14 bold">Ngày còn phòng:</p>
                                    <div class="d-flex justify-content-center">
                                        <div class="room-calendar" id="room-calendar{{$bedroom->bedroom_id}}"></div>
                                        <div>
                                            <div class="block-avail"><span class="fs-12 bold">Còn phòng</span></div>
                                            <div class="block-disable"><span class="fs-12 bold">Hết phòng</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="host-info">
                        <h4 class="fs-16 uppercase center bold mt-2">thông tin của host</h4>
                        <hr>
                        <img class="host-avatar"
                             src="{{ $homestay->user->avatar ? env('HOST_URL').'/local/storage/app/image/user/'.$homestay->user->avatar : Avatar::create($homestay->user->name)->toBase64()}}">
                        <p class="fs-16 bold">{{$homestay->user->name}}</p>
                        <div class="host-description">
                            <p>“ {{$homestay->user->description}} ” </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr>

    <section class="section-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-8">
                    <h6 class="fs-18 bold mt-4 mb-4">Khu vực xung quanh</h6>
                    <div id="map"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if( $comments->first() )
                    <h6 class="fs-18 bold mt-4 mb-4">Đánh giá</h6>
                    @endif
                    @foreach($comments as $comment)
                        <div class="review-item">
                            <div class="review-user">
                                <div class="user-ava"></div>
                                <p class="fs-14 mb-0 center bold">{{$comment->user->name}}</p>
                                <p class="fs-10 grey-9 mb-0 center"><i
                                            class="fas fa-map-marker"></i> {{$comment->user->nation}}</p>
                                {{-- <p class="fs-10 grey-9 mb-0 center">24 tuổi</p> --}}
                            </div>

                            <div class="review-content">
                                <div>
                                    <i class="fas fa-star @if($comment->comment_rate >= 2) active @endif"></i>
                                    <i class="fas fa-star @if($comment->comment_rate >= 4) active @endif"></i>
                                    <i class="fas fa-star @if($comment->comment_rate >= 6) active @endif"></i>
                                    <i class="fas fa-star @if($comment->comment_rate >= 8) active @endif"></i>
                                    <i class="fas fa-star @if($comment->comment_rate >= 10) active @endif"></i>
                                    @if($comment->comment_rate >= 10) Rất tốt @elseif($comment->comment_rate >= 8)
                                        Tốt @elseif($comment->comment_rate >= 6) Bình
                                    thường @elseif($comment->comment_rate >= 4) Không
                                    tốt @else($comment->comment_rate >= 2) Rất không tốt @endif
                                </div>
                                <div class="grey-9 fs-10">7 tuần trước</div>
                                <div class="fs-14 mt-2">
                                    {!! $comment->comment_content !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <hr>

    <section class="section-5">
        <div class="container">
            <h6 class="bold fs-18 mt-4">Các homestay khác</h6>

            <div class="row">
                <div class="owl-carousel owl-carousel-5">
                    @foreach($nearby_homestay as $homestay)
                        <div class="slide-item">
                            <a href="{{ asset('detail/'.$homestay->homestay_id) }}" class="slide-image"
                               style="display:block; background-image: url({{ is_url_exist(env('HOST_URL').'/local/storage/app/image/resized-'.$homestay->homestay_image) ? env('HOST_URL').'/local/storage/app/image/resized-'.$homestay->homestay_image : $homestay->homestay_image}})">
                                <span class="slide-where">{{$homestay->homestay_city}}</span>
                                @if( $homestay->homestay_hot == 1 )
                                    <span class="slide-hot">Hot</span>
                                @elseif( date_diff($homestay->created_at,new DateTime() )->format('%a') <= 7 )
                                    <span class="slide-new">New</span>
                                @endif
                            </a>
                            <a href="{{ asset('detail/'.$homestay->homestay_id) }}"
                               class="slide-name">{{$homestay->homestay_name}}</a>
                            <div class="slide-price">giá
                                từ: {{ number_format( getMin($homestay->bedroom,'bedroom_price') )}} Đ
                            </div>
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
@stop