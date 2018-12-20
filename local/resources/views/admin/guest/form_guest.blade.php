@extends('admin.master')

@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
@stop
@section('main')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $guest->id == 0? 'Thêm mới ': 'Chỉnh sửa '}}Thông tin khách hàng</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ asset('admin') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="">Thông tin khách hàng</a></li>
                            <li class="breadcrumb-item active">{{ $guest->id == 0? 'Thêm mới ': 'Chỉnh sửa '}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">{{ $guest->id == 0? 'Thêm mới ': 'Chỉnh sửa '}}</h3>
                            </div>
                            <form id="create_guest" action="{{route('action_guest')}}" method="post"
                                  enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="card-body">
                                    <input type="text" name="guest[id]" value="{{$guest->id}}"
                                           class="form-control d-none" placeholder="ID danh mục">

                                    <div class="row form-group">
                                        <label class="col-sm-2">Tên khách hàng <span
                                                    class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="guest[name]" required
                                                   value="{{$guest->title}}"
                                                   class="form-control" placeholder="Tiêu đề bài viết">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2">Mô tả</label>
                                        <div class="col-sm-10">
                                            <textarea type="text" name="guest[caption]" class="form-control"
                                                      placeholder="Mô tả">{{$guest->caption}}</textarea>
                                            {{--<textarea id="editor2" name="guest[caption]" rows="10"--}}
                                                      {{--cols="5">--}}
                                                                {{--{{ $guest->caption != '' ? $guest->caption : 'Mô tả' }}--}}
                                                            {{--</textarea>--}}
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2">Ngày phát hành <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="date" name="guest[release_time][day]" required
                                                   value="{{$guest->release_time->day}}" min="1000-01-01"
                                                   max="3000-12-31" class="form-control">
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="bootstrap-timepicker">
                                                <div class="input-group">
                                                    <input type="text" name="guest[release_time][h]"
                                                           value="{{$guest->release_time->h}}" class="form-control timepicker">

                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                                    </div>
                                                </div>
                                                <!-- /.form group -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group" style="max-height: 1050px">
                                        <label class="col-sm-2">Ảnh đại diện</label>
                                        <div class="col-sm-3 form-group">
                                            <input  class="d-none" id="avatar" name="avatar">
                                            <div id="img-demo"></div>
                                            <input id="img" type="file" name="img" class="cssInput"
                                                   onchange="changeImg(this)" style="display: none!important;">
                                            <img style="cursor: pointer;width: 100%;" id="avatar"
                                                 class="cssInput thumbnail imageForm"
                                                 src="{{file_exists(storage_path('app/guest/'.$guest->avatar)) ? asset('local/storage/app/guest/'.$guest->avatar) : asset('local/resources/assets/images/default-image.png')}}">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2">Nội dung bài viết</label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="box box-info">
                                                        <!-- /.box-header -->
                                                        <div class="box-body pad">
                                                            <textarea id="editor1" name="guest[content]" rows="10"
                                                                      cols="80">
                                                                {{ $guest->content != '' ? $guest->content : 'Nội dung bài viết' }}
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2">Tác giả</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="guest[author]"
                                                   value="{{$guest->author}}">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2">Trạng thái</label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <label class="col-sm-3 text-primary">
                                                    <input value="2" type="radio"
                                                           name="guest[status]" {{ $guest->status == 2 ? 'checked' : '' }}>
                                                    Hoạt động
                                                </label>
                                                <label class="col-sm-3 text-primary">
                                                    <input value="1" type="radio"
                                                           name="guest[status]" {{ $guest->status != 2 ? 'checked' : '' }}>
                                                    Không hoạt động
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-info pull-right"
                                                style="margin-right: 10px">{{ $guest->id ? 'Cập nhật' : 'Tạo mới' }}</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ./row -->
    </div>
@stop

@section('script')
    <script>
        $("#create_guest").validate({
            ignore: [],
            rules: {
                'guest[title]': {
                    required: true
                },
                'guest[caption]': {
                    required: true
                }
            },
            messages: {
                'guest[title]': {
                    required: 'Vui lòng nhập tên danh mục'
                },
                'guest[caption]': {
                    required: 'Vui lòng nhập mô tả tin tức'
                }
            }
        });
    </script>
@stop
