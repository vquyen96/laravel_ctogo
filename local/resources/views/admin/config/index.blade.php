@extends('admin.master')

@section('css')
    <style>
        .banner-image {
            position: relative;
            height: 200px;
            width: 355px;
            max-width: 100%;
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 10px;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .banner-image > a {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        #add-banner {
            background-image: url('{{ asset('local/storage/app/image/add-image.png') }}');
            background-size: contain;
            cursor: pointer;
        }
    </style>
@stop

@section('main')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Cài đặt website
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ asset('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Cài đặt website</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Banner</h3>
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-info btn-sm" data-widget="collapse"
                                        data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body pad">
                            <form id="form-banner" method="post" enctype="multipart/form-data"
                                  action="{{ asset('admin/config/banner') }}" style="display: none;">
                                <input id="input-banner" type="file" name="value" value="{{ $banner->value }}"
                                       accept="image/*">
                                {{csrf_field()}}
                            </form>

                            <div id="add-banner" class="banner-image"></div>

                            @foreach( unserialize($banner->value) as $key => $banner)
                                <div class="banner-image"
                                     style="background-image: url('{{ asset('local/storage/app/upload/'.$banner) }}')">
                                    <a href="{{ asset('admin/config/banner/delete/'.$key) }}"><i
                                                class="fa fa-2x fa-trash text-red"></i></a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <form class="box box-warning" method="post" action="{{ asset('admin/config/info') }}">
                        <div class="box-header">
                            <h3 class="box-title">Info</h3>
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-info btn-sm" data-widget="collapse"
                                        data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body pad">
                            <textarea id="editor1" name="info" rows="10" cols="80">{{ $info->value }}</textarea>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        {{csrf_field()}}
                    </form>

                    <form class="box box-danger" method="post" action="{{ asset('admin/config/term') }}">
                        <div class="box-header">
                            <h3 class="box-title">Điều khoản</h3>
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-info btn-sm" data-widget="collapse"
                                        data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body pad">
                            <textarea id="editor2" name="term" rows="10">{{ $term->value }}</textarea>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        {{csrf_field()}}
                    </form>

                    <form class="box box-success" method="post" action="{{ asset('admin/config/policy') }}">
                        <div class="box-header">
                            <h3 class="box-title">Chính sách</h3>
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-info btn-sm" data-widget="collapse"
                                        data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body pad">
                            <textarea id="editor3" name="policy" rows="10">{{ $policy->value }}</textarea>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        {{csrf_field()}}
                    </form>
                </div>
            </div>
        </section>
    </div>
@stop

@section('javascript')
    <script src="bower_components/ckeditor/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            $('#add-banner').click(function () {
                $('#input-banner').click();
            });
            $('#input-banner').change(function () {
                $('#form-banner').submit();
            });
        });
        $(function () {
            CKEDITOR.replace('editor1');
            CKEDITOR.replace('editor2');
            CKEDITOR.replace('editor3');
        })
    </script>
@stop