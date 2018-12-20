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
                        <h1 class="m-0 ">Danh sách tài khoản chủ nhà</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('admin') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách tài khoản chủ nhà</li>
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
                                    <th>#id</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Ngày tạo</th>
                                    <th>Nguồn</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list_host as $host)
                                    <tr>
                                        <td>{{$host->id}}</td>
                                        <td>
                                            <a style="color: #0a0a0a" href="{{route("detail_host",$host->id)}}">
                                                <div style="display: flex">
                                                    @if(file_exists(storage_path('app/image/user-3/'.$host->avatar)) && $host->avatar != '')
                                                        <div class="avatar_user"
                                                             style="background-image: url('{{asset('local/storage/app/image/user-3/'.$host->avatar)}}')">
                                                        </div>
                                                    @elseif(is_url_exist($host->avatar))
                                                        <div class="avatar_user"
                                                             style="background-image: url('{{$host->avatar}}')">
                                                        </div>
                                                    @else
                                                        <div class="avatar_user"
                                                             style="background-image: url('{{asset('local/storage/app/image/user-3/default.png')}}')">
                                                        </div>
                                                    @endif
                                                    <div style="display: flex;line-height: 40px">
                                                        {{$host->name}}
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td>{{$host->email}}</td>
                                        <td>{{$host->phone}}</td>
                                        <td>{{$host->created_at}}</td>
                                        <td>
                                            {{getSocial($host->social_type)}}
                                        </td>
                                        <td class="text-center">
                                            <button id="{{$host->id}}" onclick="update_status({{$host->id}})"
                                                    class="btn btn-block btn-sm {{$host->status == 2 ? 'btn-success': 'btn-danger'}}">{{$host->status == 2 ? 'Hoạt đông': 'Không hoạt đông'}}</button>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('delete_host',$host->id)}}"
                                               onclick="return confirm('Bạn chắc chắn muốn xóa')" data-toggle="tooltip"
                                               title="Xóa" class="text-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="form-group pull-right">
                                {{$list_host->links()}}
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
    <div class="modal fade" id="detail_group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">

    </div>
@stop

@section('javascript')
    <script>
        function update_status(id) {
            $.ajax({
                url: '/admin/host/update_status_host/' + id,
                method: 'get',
                dataType: 'json',
            }).fail(function (ui, status) {
            }).done(function (data, status) {
                if (data.host) {
                    data.host = JSON.parse(data.host);

                    var id = '#' + data.host.id;

                    if (data.host.status == 2) {
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
    </script>
@stop