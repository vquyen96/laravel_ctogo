@extends('admin.master')

@section('css')
@stop
@section('js')
@stop
@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Thông tin homestay của
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle"
                                 src="{{ is_url_exist($host->avatar) ? $host->avatar : (file_exists(asset('local/storage/app/image/user/'.$host->avatar)) && $host->avatar) ? asset('local/storage/app/image/user/'.$host->avatar) : asset('local/storage/app/image/user-3/default.png') }}" alt="User profile picture">

                            <h3 class="profile-username text-center">{{$host->name}}</h3>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Họ và tên</b> <a class="pull-right">{{$host->name}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="pull-right">{{$host->email}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Số điện thoại</b> <a class="pull-right">{{$host->phone}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Quốc gia</b> <a class="pull-right">{{$host->nation}}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#homestay" data-toggle="tab">Danh sách homestay</a></li>
                            <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                            <li><a href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="homestay">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#id</th>
                                        <th>Tên homestay</th>
                                        <th>Avatar</th>
                                        <th>Địa chỉ</th>
                                        <th>Số lượt thuê</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($list_homestay as $homestay)
                                            <tr>
                                                <td>{{$homestay->homestay_id}}</td>
                                                <td onclick="view_detail('{{$homestay->homestay_id}}')">{!! $homestay->homestay_name !!}</td>
                                                <td>
                                                    <div class="avatar_user"
                                                         style="background-image: url('{{ is_url_exist(env('HOST_URL').'/local/storage/app/image/resized-'.$homestay->homestay_image) ? env('HOST_URL').'/local/storage/app/image/resized-'.$homestay->homestay_image : $homestay->homestay_image}}')">
                                                    </div>
                                                </td>
                                                <td>{{$homestay->homestay_location}}</td>
                                                <td>{{isset($homestay->book) ? $homestay->book->count() : 0}}</td>
                                                <td class="text-center">
                                                    <button id="{{$homestay->homestay_id}}" onclick="update_status({{$homestay->homestay_id}})"
                                                            class="btn btn-block btn-sm {{$homestay->homestay_active == 2 ? 'btn-success': 'btn-danger'}}">{{$homestay->homestay_active == 2 ? 'Hoạt đông': 'Không hoạt đông'}}</button>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{route('delete_homestay',$homestay->homestay_id)}}"
                                                       onclick="return confirm('Bạn chắc chắn muốn xóa')"
                                                       data-toggle="tooltip"
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
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">

                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputName" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputEmail"
                                                   placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputName" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="inputExperience"
                                                      placeholder="Experience"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputSkills"
                                                   placeholder="Skills">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> I agree to the <a href="#">terms and
                                                        conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

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