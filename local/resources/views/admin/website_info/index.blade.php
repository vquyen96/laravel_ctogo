@extends('admin.master')

@section('css')
@stop
@section('main')
    <div class="content-wrapper">
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Thông tin Website</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ asset('admin') }}">Trang chủ</a></li>
                  
                  <li class="breadcrumb-item active">Chỉnh sửa thông tin</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <!-- left column -->
                <div class="col-md-8 col-sm-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Thông tin</h3>
                        </div>
                        <form id="create_group" action="{{route('update_info')}}" method="post">
                            {{csrf_field()}}
                            <div class="card-body">
                                @foreach($website_info->value as $key => $info)
                                    <div class="row form-group">
                                        <label class="col-sm-2">{{$key}}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="info[{{$key}}]" value="{{$info}}" class="form-control">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                
                            <div class="box-footer card-footer">
                                <button type="submit" class="btn btn-info pull-right">Cập nhật
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12" style="padding-left: 30px">
                    <div class="row">
                        <label>Người cập nhật : {{isset($website_info->user_updated) ? $website_info->user_updated->name : 'admin'}}</label>
                    </div>
                    <div class="row">
                        <label>Ngày cập nhật : {{date('d/m/y H:m',$website_info->updated_at)}}</label>
                    </div>
                </div>
            </div>
          </div>
            <!-- ./row -->
        </section>
    </div>
@stop

@section('script')
@stop
