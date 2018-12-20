@extends('public.master')

@section('css')
<link rel="stylesheet" type="text/css" href="login/css/login.css">
@stop

@section('javascript')
<script src="https://apis.google.com/js/platform.js" async defer></script>
@stop

@section('main')
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : '893251737550173',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v3.0'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


</script>


<section class="section-1">
	<form id="signup" class="login-container" method="post" action="{{ asset('signup') }}">
		<div class="login-form">
			<h6 class="fs-18 bold uppercase center white">đăng ký(khách hàng)</h6>
			<input type="text" name="name" placeholder="Họ và tên">
			<input type="email" name="email" placeholder="Email">
			<input type="password" id="password" name="password" placeholder="Mật khẩu">
			<input type="password" name="password_confirm" placeholder="Xác nhận mật khẩu">
			<button class="login-btn" type="submit">Đăng ký</button>

			<div class="fs-14 center white mt-4 side-dash-both"><span>Hoặc</span></div>

            <div class="social-cont">
                <a class="fb-btn" href="{{route('soicial','facebook')}}" style="text-decoration: none"><i class="fab fa-facebook-f"></i> Đăng nhập với Facebook</a>
            </div>

            <div class="social-cont">
                <a class="gg-btn" href="{{route('soicial','google')}}"><i class="fab fa-google-plus-g"></i> Đăng nhập với Google</a>
            </div>

			<p class="fs-12 white center mt-3">Bạn đã có tài khoản? <a class="main-color" href="{{ asset('login') }}">Đăng nhập</a></p>
		</div>

    {{csrf_field()}}
	</form>
</section>
@stop