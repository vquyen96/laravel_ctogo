@extends('public.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="index/css/support.css">
@stop

@section('javascript')
@stop

@section('main')
    <section class="hs-section pb-200">
        <div class="container">
            <div class="support-content">
                <h1>CHÍNH SÁCH BẢN QUYỀN</h1>

                {!! $policy !!}

            </div>
        </div>
    </section>
@stop