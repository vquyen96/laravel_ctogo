<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CTOGO ADMIN | Dashboard</title>

    <base href="{{ asset('local/storage/app/admin') }}/">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('admin.partials.css')
</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">
    @include('admin.partials.header')

    @include('admin.partials.sidebar')

    @yield('main')

    @include('admin.partials.footer')

    @include('admin.partials.sidebar-right')
    <div class="errorAlert">
        @include('errors.note')
    </div>
</div>

@include('admin.partials.js')

<script>
    $('.errorAlert').css('bottom','100px');
    setTimeout(function(){
        $('.errorAlert').css('bottom', '-200px');
    }, 3000);
    setTimeout(function(){
        $('.errorAlert').fadeOut();
    }, 3900);
</script>
</body>
</html>
