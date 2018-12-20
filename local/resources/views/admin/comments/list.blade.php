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
                        <h1 class="m-0 ">Danh sách bình luận</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('admin') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách bình luận</li>
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
                                    <th>#STT</th>
                                    <th>Đánh giá(thang 10)</th>
                                    <th>Homestay</th>
                                    <th>Người tạo</th>
                                    <th>Ngày tạo</th>
                                    <th>Trang chủ</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list_comment as $comment)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$comment->comment_rate}}</td>
                                        <td>{!! isset($comment->homestay) ? $comment->homestay->homestay_name : '' !!}</td>
                                        <td style="display: flex">
                                            @if(isset($comment->user))
                                                <div class="avatar_user"
                                                     style="background-image: url('{{file_exists(storage_path('app/image/user-3/'.$comment->user->avatar)) ? asset('local/storage/app/image/user-3/'.$comment->user->avatar) : asset('local/storage/app/image/user-3/default.png')}}')">
                                                </div>
                                                <div style="display: flex;line-height: 40px">
                                                    {{$comment->user->name}}
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{$comment->created_at}}</td>
                                        <td class="text-center">
                                            <button id="comment-{{$comment->comment_id}}" onclick="update_home({{$comment->comment_id}})"
                                                    class="btn btn-block btn-sm {{$comment->home == 2 ? 'btn-success': 'btn-primary'}}">{{$comment->home == 2 ? 'Trang chủ': 'Không'}}</button>
                                        </td>
                                        <td class="text-center">
                                            <button id="{{$comment->comment_id}}" onclick="update_status({{$comment->comment_id}})"
                                                    class="btn btn-block btn-sm {{$comment->status == 2 ? 'btn-success': 'btn-danger'}}">{{$comment->status == 2 ? 'Hoạt đông': 'Không hoạt đông'}}</button>
                                        </td>
                                        <td class="text-center">
                                            <a style="cursor: pointer"
                                               onclick="view_detail('{{$comment->comment_content}}')" data-toggle="tooltip"
                                               title="Xem comment" class="text-success"><i class="fa fa-eye"></i></a>

                                            <a href="{{route('delete_comment',$comment->comment_id)}}"
                                               onclick="return confirm('Bạn chắc chắn muốn xóa')" data-toggle="tooltip"
                                               title="Xóa" class="text-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="form-group pull-right">
                                {{$list_comment->links()}}
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
                    <h4 class="modal-title">Chi tiết bình luận</h4>
                </div>
                <div class="modal-body">
                    <p id="comment"></p>
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

        function update_home(id) {
            $.ajax({
                url: '/admin/comment/update_home_comment/' + id,
                method: 'get',
                dataType: 'json',
            }).fail(function (ui, status) {
            }).done(function (data, status) {
                if (data.comment) {
                    data.comment = JSON.parse(data.comment);

                    var id = '#comment-' + data.comment.comment_id;

                    if (data.comment.home == 2) {
                        $(id).removeClass('btn-primary');
                        $(id).addClass('btn-success');
                        $(id).html('Trang chủ');
                    } else {
                        $(id).removeClass('btn-success');
                        $(id).addClass('btn-primary');
                        $(id).html('Không');
                    }
                }
            });
        }

        function view_detail(comment) {
            $("#comment").html(comment);
            $("#myModal").modal("show");
        }
    </script>
@stop