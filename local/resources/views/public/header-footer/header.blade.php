<div id="header-subtitute"></div>

<div id="header">
	<section id="header-top">
		<div class="container header-top">
			<a href="{{ asset('/') }}" class="logo"></a>
			<figure class="language">
				<a><img src=" {{ asset('local/storage/app/public/header-footer/image/vn.png') }} "></a>
				<ul>
					<li><a><img src="{{ asset('local/storage/app/public/header-footer/image/vn.png') }}"> Tiếng Việt</a></li>
					<li><a><img src="{{ asset('local/storage/app/public/header-footer/image/en.png') }}"> Tiếng Anh</a></li>
				</ul>
			</figure>

			<div id="menu-button"><a><span></span><span></span><span></span><span></span></a></div>

			<ul class="login-register">
				@if( Auth::check() )
				<li><a class="user-tab">
					<div class="avatar"
						 style="background-image: url({{ (file_exists(storage_path('app/image/user-3/'.Auth::user()->avatar)) && Auth::user()->avatar != '') ? asset('local/storage/app/image/user-3/'.Auth::user()->avatar) : Auth::user()->avatar }} )">
						<span class="has-noti {{$count_notification <= 0 ? 'd-none' : ''}}">{{$count_notification}}</span>
					</div>
					{{ Auth::user()->name }} <i class="fas fa-angle-down"></i></a>
					<ul class="dropdown-user">
						<li><a data-target="#account" href="{{ asset('user/profile#account') }}">Tài khoản của bạn</a></li>
						<li><a data-target="#password" href="{{ asset('user/profile#password') }}">Thay đổi mật khẩu</a></li>
						<li><a data-target="#manage" href="{{ asset('user/profile#manage') }}">Quản lý đặt phòng</a></li>
						<li><a data-target="#noti" href="{{ asset('user/profile#noti') }}">Thông báo</a></li>
						<li><a href="{{ asset('user/logout') }}">Đăng xuất</a></li>
					</ul>
				</li>
				@else
				<li><a href="{{ asset('login') }}">Đăng nhập</a></li>
				<li><a href="{{ asset('signup') }}">Đăng ký</a></li>
				@endif
			</ul>
		</div>
	</section>

	@yield('header-bottom')
</div>