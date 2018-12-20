@extends('admin.master')

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <style>
        .example-modal .modal {
            position: relative;
            top: auto;
            bottom: auto;
            right: auto;
            left: auto;
            display: block;
            z-index: 1;
        }

        .example-modal .modal {
            background: transparent !important;
        }
    </style>
@stop

@section('javascript')
    <!-- DataTables -->
    <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- page script -->
    <script>
        $(document).ready(function () {
            $('.btn-permission').click(function (e) {
                e.preventDefault();
                $(this).closest('tr').next('tr').slideToggle();
            });

            @if( Session::get('success') )
            $('#modal-success').modal();
            @endif
        });
    </script>
@stop

@section('main')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Quản lý tài khoản admin
                {{--<small>advanced tables</small>--}}
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Quản lý tài khoản admin</li>
                <li class="active">Danh sách admin</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3 col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thêm quản trị viên</h3>
                        </div>
                        <form class="form-horizontal" method="post" action="{{ asset('admin/account/add') }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" name="email"
                                               placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Tên</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName" name="name"
                                               placeholder="Họ tên">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Quyền</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="permiss[]" value="1">
                                                        Quản lý tài khoản khách
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="permiss[]" value="2">
                                                        Quản lý chủ nhà
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="permiss[]" value="3">
                                                        Quản lý bình luận
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="permiss[]" value="4">
                                                        Quản lý homestay
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="permiss[]" value="5">
                                                        Cài đặt website
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right">Thêm</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Danh sách admin</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Email</th>
                                    <th>Tên</th>
                                    <th>Mật khẩu</th>
                                    <th>Quyền</th>
                                    <th>Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->id ?? 'id' }}</td>
                                        <td>{{ $admin->email ?? 'email' }}</td>
                                        <td>{{ $admin->name ?? 'tên' }}</td>
                                        <td>
                                            @if( !$admin->isSuperAccount() )
                                                <form method="post"
                                                      action="{{ asset('admin/account/resetPassword/'.$admin->id) }}">
                                                    {{csrf_field()}}
                                                    <button type="submit" class="btn btn-small bg-purple">Reset</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td>
                                            @if( !$admin->isSuperAccount() ) <a
                                                    class="btn btn-primary btn-block btn-permission">Cấp
                                                quyền</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if( !$admin->isSuperAccount() )
                                                <a onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?')"
                                                   href="{{ asset('admin/account/delete/'.$admin->id) }}"><i
                                                            class="fa fa-trash"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @if( !$admin->isSuperAccount() )
                                        <tr style="display: none;">
                                            <td colspan="999">
                                                <form class="form-group" method="post" enctype="multipart/form-data"
                                                      action="{{ asset('admin/account/updatePermission/'.$admin->id) }}">
                                                    {{csrf_field()}}
                                                    <label class="col-sm-2 control-label col-xs-12">Quyền</label>
                                                    <div class="col-sm-10 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-lg-2 col-xs-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="permiss[]"
                                                                               @if( $admin->isPermissed(1) ) checked
                                                                               @endif value="1">
                                                                        Quản lý tài khoản khách
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-xs-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="permiss[]"
                                                                               @if( $admin->isPermissed(2) ) checked
                                                                               @endif value="2">
                                                                        Quản lý chủ nhà
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-xs-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="permiss[]"
                                                                               @if( $admin->isPermissed(3) ) checked
                                                                               @endif value="3">
                                                                        Quản lý bình luận
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-xs-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="permiss[]"
                                                                               @if( $admin->isPermissed(4) ) checked
                                                                               @endif value="4">
                                                                        Quản lý homestay
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-xs-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="permiss[]"
                                                                               @if( $admin->isPermissed(5) ) checked
                                                                               @endif value="5">
                                                                        Cài đặt website
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2 col-md-offset-2">
                                                        <button class="btn btn-default bg-aqua">Xác nhận</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>

                            {{ $admins->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop