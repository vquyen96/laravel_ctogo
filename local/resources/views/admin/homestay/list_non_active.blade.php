@extends('admin.master')

@section('js')
    <!-- Slimscroll -->
    <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
@stop

@section('title', 'Quản trị')
@section('main')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 ">Danh sách homestay</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('admin') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách homestay</li>
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
                                    <div class="col-md-4">
                                        <a class="btn btn-primary" href="{{route('sort_homestay')}}">Sắp xếp homestay</a>
                                    </div>
                                    <div class="col-md-4">

                                    </div>
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
                                    <th>#STT</th>
                                    <th>Tên homestay</th>
                                    <th>Avatar</th>
                                    <th>Người tạo/Ngày tạo</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list_homestay as $homestay)
                                    <tr>
                                        <td>{{(10*($list_homestay->currentPage() -1) ) + $loop->index + 1}}</td>
                                        <td>{!! $homestay->homestay_name !!}</td>
                                        <td>
                                            <div class="avatar_user"
                                                 style="background-image: url('{{ is_url_exist(env('HOST_URL').'/local/storage/app/image/resized-'.$homestay->homestay_image) ? env('HOST_URL').'/local/storage/app/image/resized-'.$homestay->homestay_image : $homestay->homestay_image}}')">
                                            </div>
                                        </td>
                                        <td>
                                            <span><b>Người tạo:</b></span> {!! isset($homestay->user) ? $homestay->user->email : '' !!} <br>
                                            <span><b>Ngày tạo: </b></span> {{$homestay->created_at}}
                                        </td>
                                        <td class="text-center">
                                            <button id="{{$homestay->homestay_id}}" onclick="update_status({{$homestay->homestay_id}})"
                                                    class="btn btn-block btn-sm {{$homestay->homestay_active == 2 ? 'btn-success': 'btn-danger'}}">{{$homestay->homestay_active == 2 ? 'Hoạt đông': 'Không hoạt đông'}}</button>
                                        </td>
                                        <td class="text-center">
                                            <a style="cursor: pointer"
                                               onclick="view_detail('{{$homestay->homestay_id}}')" data-toggle="tooltip"
                                               title="Xem homestay" class="text-success"><i class="fa fa-eye"></i></a>

                                            <a href="{{route('delete_homestay',$homestay->homestay_id)}}"
                                               onclick="return confirm('Bạn chắc chắn muốn xóa')" data-toggle="tooltip"
                                               title="Xóa" class="text-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="form-group pull-right">
                                {{$list_homestay->links()}}
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
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Chi tiết homestay</h4>
                </div>
                <div class="modal-body" style="padding: 0 20px">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>

        </div>
    </div>
@stop

@section('javascript')
    <script>
        function update_status(id) {
            $.ajax({
                url: '/admin/homestay/update_status_homestay/' + id,
                method: 'get',
                dataType: 'json',
            }).fail(function (ui, status) {
            }).done(function (data, status) {
                if (data.homestay) {
                    data.homestay = JSON.parse(data.homestay);

                    var id = '#' + data.homestay.homestay_id;

                    if (data.homestay.homestay_active == 2) {
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

        function view_detail(id) {
            $.ajax({
                url: '/admin/homestay/view_detail/' + id,
                method: 'get',
                dataType: 'json',
            }).fail(function (ui, status) {
            }).done(function (data, status) {
                if (data.view) {
                    $(".modal-body").html(data.view);
                    $("#myModal").modal("show");
                }
            });
        }
    </script>
@stop