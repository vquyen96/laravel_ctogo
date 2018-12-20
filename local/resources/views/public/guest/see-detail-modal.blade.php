<div>
    <h3>Chi tiết đặt phòng</h3>
    <p>Mã đặt phòng: <span class="bold">{{$book->code}}</span> <br>Tình trạng đặt phòng: <span class="bold">{{getStatusBookStr($book->book_status)['str']}}</span> </p>

    <table>
        <thead>
        <tr>
            <td colspan="2">Thông tin liên hệ</td>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td width="40%">Tên người liên hệ</td>
            <td width="60%">{{$homestay->user->name}}</td>
        </tr>
        <tr>
            <td>Điện thoại</td>
            <td>{{$homestay->user->phone}}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{$homestay->user->email}}</td>
        </tr>
        </tbody>
    </table>

    <table>
        <thead>
        <tr>
            <td colspan="2">Thông tin đặt phòng</td>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td width="40%"><img src="https://cdn.luxstay.com/rooms/13535/thumbnail/1531289020_Homestay%20Old%20Quarter%20View%20House%20Easternstay%20-2.jpg?w=250&fit=crop&v=147660"></td>
            <td width="60%">{{$homestay->homestay_name}}</td>
        </tr>
        <tr>
            <td>Phòng</td>
            <td>Luxury Bedroom 1</td>
        </tr>
        <tr>
            <td>Ngày đến</td>
            <td>{{ $book->book_from}}</td>
        </tr>
        <tr>
            <td>Ngày đi</td>
            <td>{{ $book->book_to}}</td>
        </tr>
        <tr>
            <td>Số người</td>
            <td>{{$bedroom->bedroom_slot}}</td>
        </tr>
        <tr>
            <td>Giá phòng / 1 đêm</td>
            <td>{{number_format($bedroom->bedroom_price)}}đ</td>
        </tr>
        <tr>
            <td>TỔNG</td>
            <td>{{number_format($book->price)}}đ <span class="grey-6 line-through fs-12">{{number_format($book->price /0.8)}}đ</span> <span class="fs-10 italic red">Giảm 20%</span></td>
        </tr>
        </tbody>
    </table>

    <table>
        <thead>
        <tr>
            <td colspan="2">Ảnh ủy nhiệm chi</td>
        </tr>
        </thead>

        <tbody>
        @if(file_exists(storage_path('app/image/image-payment/'.$book->image_payment)))
            <tr>
                <td width="100%"><img src="{{asset('local/storage/app/image/image-payment/'.$book->image_payment)}}"></td>
            </tr>
        @endif
        </tbody>
    </table>
</div>