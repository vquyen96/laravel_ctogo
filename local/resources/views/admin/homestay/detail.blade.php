<div class="row form-group">
    <b>Tên homestay:</b> {{$homestay->name}}
</div>

<div class="row form-group">
    <b>Người tạo:</b> @if(isset($homestay->user)) {{$homestay->user->name}} / {{$homestay->user->email}} @endif
</div>

<div class="row form-group">
    <b>Ngày tạo:</b> {{$homestay->created_at}}
</div>

<div class="row form-group">
    <b>Danh sách phòng ngủ:</b><br>
    @if(isset($homestay->bedroom))
        <table id="example2" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#STT</th>
                <th>Tên phòng ngủ</th>
                <th>Số người/phòng</th>
                <th>Ngày tạo</th>
                <th>Giá</th>
            </tr>
            </thead>
            <tbody>
            @foreach($homestay->bedroom as $bedroom)
                <tr>
                    <td>{{$loop->index + 1}}</td>
                    <td>{!! $bedroom->bedroom_name !!}</td>
                    <td>{!! $bedroom->bedroom_slot !!}</td>
                    <td>
                        <span><b>Ngày tạo: </b></span> {{$homestay->created_at}}
                    </td>
                    <td>{{number_format($bedroom->bedroom_price)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="row form-group">
    <div class="col-md-12">
        <b style="margin-left: -15px">Danh sách hình ảnh:</b>
    </div>
    @if(isset($homestay->homestayimage))
        @foreach($homestay->homestayimage as $img)
            <div class="col-md-4">
                <img style="width: 100%" src="{{ is_url_exist(env('HOST_URL').'/local/storage/app/image/resized-'.$img->homestay_image_img) ? env('HOST_URL').'/local/storage/app/image/resized-'.$img->homestay_image_img : $img->homestay_image_img}}">
            </div>
        @endforeach
    @endif
</div>

