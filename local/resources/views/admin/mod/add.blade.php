@extends('admin.master')

@section('main')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Quản lý tài khoản admin
                {{--<small>Preview</small>--}}
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Quản lý tài khoản admin</a></li>
                <li class="active">Thêm tài khoản admin</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thêm tài khoản admin</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Điền email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName">Tên</label>
                                    <input type="email" class="form-control" id="exampleInputName" placeholder="Điền tên">
                                </div>
                                <div class="form-group">
                                    <label>Quyền quản trị</label>
                                    <select class="form-control">
                                        <option>Cấp 1</option>
                                        <option>Cấp 2</option>
                                        <option>Cấp 3</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop