<p class="grey-9 fs-10 right">Hiển thị {{ count($homestays) }}
    trên {{($homestays->lastPage()-1) * $homestays->perpage() + $homestays->count()}} homestay</p>

@if( $homestays->count() != 0 )
    @foreach($homestays as $homestay)
        <div class="homestay-item">
            <a href="{{ asset('detail/'.$homestay->homestay_id) }}" class="item-image"
               style="background-image: url( {{ is_url_exist(env('HOST_URL').'/local/storage/app/image/'.$homestay->homestay_image) ? env('HOST_URL').'/local/storage/app/image/'.$homestay->homestay_image : $homestay->homestay_image }} ) ;"></a>
            <div class="item-content">
                <a href="{{ asset('detail/'.$homestay->homestay_id) }}"
                   class="italic grey-3 fs-16 mb-1">{{strip_tags($homestay->homestay_name)}}</a>
                <p class="grey-9 fs-10 mb-1">{{$homestay->homestay_location}}</p>
                <p class="grey-9 fs-10 mb-2">
                    <i class="fas fa-door-open"></i> {{ count($homestay->bedroom) }}
                    <i class="fas fa-user ml-4"></i> {{ getMax($homestay->bedroom, 'bedroom_slot') }}
                </p>
                <p class="fs-12 black">{!! cut_string($homestay->homestay_about, 150) !!}</p>
                <div class="slide-price">giá
                    từ: {{ number_format( getMin($homestay->bedroom,'bedroom_price'),0,',','.' ) }}
                    Đ
                </div>
                <div class="slide-review">
                    <span class="slide-score">{{ getAverage($homestay->comment,'comment_rate') }}</span>
                    <a class="slide-grade">
                        <span>Xuất sắc</span>
                        <span class="hs-small-text">{{ count($homestay->comment) }} đánh giá</span>
                    </a>
                </div>
            </div>
        </div>
    @endforeach

    <div id="myPagination">
        @if( $homestays->currentPage() > 1 )
            <a class="myPagination" data-page="1"> <i class="fas fa-angle-double-left"></i> </a>
            <a class="myPagination" data-page="{{ $homestays->currentPage()-1 }}"> <i class="fas fa-angle-left"></i>
            </a>
        @endif

        @if( $homestays->lastPage() < 6 )
            @for ( $i = 1; $i <= $homestays->lastPage(); $i++ )
                <a class="myPagination @if( $i == $homestays->currentPage() ) active @endif"
                   data-page="{{$i}}">{{ $i }}</a>
            @endfor
        @else
            @if( $homestays->currentPage() > 3 )
                <a class="myPagination disabled" data-page="1"> ... </a>
            @endif

            @for ( $i = ($homestays->currentPage() - 2 > 0) ? ($homestays->currentPage() - 2) : 1 ; $i <= ( ( $homestays->currentPage() + 2 < $homestays->lastPage() ) ? ($homestays->currentPage() + 2) : $homestays->lastPage() ); $i++ )
                <a class="myPagination @if( $i == $homestays->currentPage() ) active @endif"
                   data-page="{{$i}}">{{ $i }}</a>
            @endfor

            @if( $homestays->currentPage() < $homestays->lastPage() - 2 )
                <a class="myPagination disabled" data-page="1"> ... </a>
            @endif
        @endif


        @if( $homestays->currentPage() < $homestays->lastPage())
            <a class="myPagination" data-page="{{ $homestays->currentPage()+1 }}"> <i class="fas fa-angle-right"></i>
            </a>
            <a class="myPagination" data-page="{{ $homestays->lastPage() }}"> <i class="fas fa-angle-double-right"></i>
            </a>
        @endif
    </div>
@endif