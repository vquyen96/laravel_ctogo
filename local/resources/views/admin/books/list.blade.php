@extends('admin.master')

@section('javascript')
    <script>
        function update_status(id) {
            $.ajax({
                url: '/admin/comment/update_status_comment/' + id,
                method: 'get',
                dataType: 'json',
            }).fail(function (ui, status) {
            }).done(function (data, status) {
                if (data.comment) {
                    data.comment = JSON.parse(data.comment);

                    var id = '#' + data.comment.comment_id;

                    if (data.comment.status == 2) {
                        $(id).removeClass('btn-danger');
                        $(id).addClass('btn-success');
                        $(id).html('Hoạt động');
                    } else {
                        $(id).removeClass('btn-success');
                        $(id).addClass('btn-danger');
                        $(id).html('Không hoạt động');
                    }
                }
            });
        }
        function seeDetailModal(id)
        {
            $.ajax({
                url : "/admin/books/seeDetailModal?id="+id,
                type : "get",
                success : function (result){
                    $('#detailModal .modal-body').html(result);
                    $('#detailModal').modal('show');
                }
            });
        }
    </script>
@stop


@section('title', 'Quản trị')
@section('main')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 ">Danh sách đơn</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('admin') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách đơn</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="padding: 20px">
                            <div class="row">
                                <form action="" method="get">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">

                                        <div class="input-group input-group-sm float-right" style="width: 100%;">
                                            <input type="text" name="search" class="form-control pull-right"
                                                   placeholder="Search">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-default"><i
                                                            class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td>#STT</td>
                                    <td>Mã đặt phòng</td>
                                    <td>Homestay</td>
                                    <td>Thời gian</td>
                                    <td>Chờ thanh toán</td>
                                    <td>Chi phí</td>
                                    <td>Tình trạng</td>
                                    <td style="min-width: 120px" class="pull-right">Thao tác</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list_book as $book)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$book->code}}</td>
                                        @if($book->homestay)
                                            <td>{{ $book->homestay->homestay_name }}</td>
                                        @else
                                            <td>Homestay đã dừng hoạt động</td>
                                        @endif
                                        <td>{{$book->book_from}} -- {{$book->book_to}}</td>
                                        @if($book->book_status != 3)
                                            <td>{{$book->del_time['h']}}:{{$book->del_time['m']}}:{{$book->del_time['s']}}</td>
                                        @else
                                            <td>0</td>
                                        @endif

                                        <td>{{number_format($book->price)}} vnd</td>
                                        <td><span class="text-warning" title="{{getStatusBookStr($book->book_status)['title']}}">{{getStatusBookStr($book->book_status)['str']}}</span></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn {{getStatusBookStr($book->book_status)['class']}} dropdown-toggle form-control" data-toggle="dropdown" title="{{getStatusBookStr($book->book_status)['title']}}" aria-haspopup="true" aria-expanded="false">
                                                    {{getStatusBookStr($book->book_status)['str']}}
                                                </button>
                                                <div class="dropdown-menu animated lightSpeedIn">
                                                    <div>
                                                        <a title="{{getStatusBookStr(3)['title']}}" class="dropdown-item" href="{{route('update_book_status',['book_id' => $book->book_id,'status' => 3])}}">Hoàn thành</a>
                                                    </div>
                                                    <div>
                                                        <a title="{{getStatusBookStr(4)['title']}}" class="dropdown-item" href="{{route('update_book_status',['book_id' => $book->book_id,'status' => 4])}}">Hủy</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="pull-right action-order" style="border: 0px;margin-right: 12px">
                                            @if(file_exists(storage_path('app/image/image-payment/'.$book->image_payment)) && $book->image_payment != null)
                                                <a book_id="{{$book->book_id}}" class="image_payment" style="cursor: pointer" title="Ảnh phiếu ủy nhiệm chi"><i class="fa fa-image text-danger"></i></a>
                                            @endif
                                            <a onclick="seeDetailModal('{{$book->book_id}}')" title="Chi tiết"><i class="fa fa-eye text-primary"></i></a>
                                            <a href="{{route('update_status_book',['id' => $book->book_id,'status' => 4])}}" title="Hủy"><i class="fa fa-trash text-danger"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="form-group pull-right">
                                {{$list_book->links()}}
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    {{--ajax see detail modal here--}}
                </div>
            </div>
        </div>
    </div>
@stop

