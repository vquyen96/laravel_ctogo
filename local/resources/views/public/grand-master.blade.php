<!DOCTYPE html>
<html>
<head>
	<title></title>
	<base href="{{ asset('local/storage/app/public') }}/">
	<link rel="icon" type="image/ico" href="base/image/favicon.png"/>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="google-signin-client_id" content="758738020038-ke08tcku4c5rugooldj91ajm5esss6a6.apps.googleusercontent.com">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<meta property="og:title" content="LẠC LỐI Ở SINGAPORE" />
	<meta property="og:type" content="website" />
	<meta property="fb:app_id" content="474784366353780" />
	<meta property="og:description" content="Singapore hay còn gọi là Tân Giai Ba, cách Việt Nam chừng 2 giờ bay, là một quốc đảo.  Kì ở chỗ cũng chỉ là cùng một nơi thôi mà có người đến đó mê mẩn quên cả lối về. Trong một diễn biến khác thì có người tới 1 lần rồi thì cạch mặt thề không bao giờ quay lại: “bé như cái lỗ mũi đắt lòi và chán chết”. Thật ra Singopore trong mắt tôi là những toà nhà cao chọc trời, những trung tâm mua sắm hàng hiệu sáng bóng và chảnh choẹ. Bởi vậy, tự nhủ chắc phải mang đâu có hơn ngàn đô chỉ để mua sắm bét nhè rồi đi về.Bài học nhân khẩu ghi là: 74,2% cư dân là người gốc Hoa, 13,4% là người gốc Mã Lai, và 9,2% là người gốc Ấn Độ, người Âu, Á và các nhóm khác chiếm 3,2% nên cả nhà cứ nghĩ xem, chỉ đi đến Singapore mà gặp được 4 nền văn hoá, tội gì không khám phá một thể cho tiện." />
	<meta property="og:url" content="https://blog.ctogo.vn/bai-viet/lac-loi-o-singapore/6" />
	<meta property="og:image" content="https://blog.ctogo.vn/storage/app/image/blog_2018-07-26_1532569445.jpeg" />

	<!-- css -->
	<link rel="stylesheet" type="text/css" href="base/css/reset.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="base/css/base.css">
	<link rel="stylesheet" type="text/css" href="header-footer/css/header-footer.css">
	
	@yield('css')
	<!-- end css -->
</head>

<body>
	<div id="wrapper">
		{{-- HEADER --}}
		@include('public.header-footer.header')
		{{-- END HEADER --}}

		{{-- MAIN --}}
		<div id="main">
			@yield('main')
		</div>
		{{-- END MAIN --}}

		{{-- FOOTER --}}
		@include('public.header-footer.footer')
		{{-- END FOOTER --}}

		<div class="errorAlert">
			@include('errors.note')
		</div>
	</div>
	<div id="snackbar"></div>
	<!-- script -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"
			integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
			integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
			crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
			integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
			crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>

	<script type="text/javascript" src="header-footer/js/header-footer.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>

	<script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
	</script>

	<script>
        $('.errorAlert').css('bottom','100px');
        setTimeout(function(){
            $('.errorAlert').css('bottom', '-200px');
        }, 3000);
        setTimeout(function(){
            $('.errorAlert').fadeOut();
        }, 3900);


        {{--//var socket = io('http://localhost:3000');--}}
        {{--var socket = io('https://172.16.9.239:3000',verify=false);--}}
        {{--console.log('chào',socket);--}}
        {{--socket.on("haivl-channel.{{\Illuminate\Support\Facades\Auth::user() ? \Illuminate\Support\Facades\Auth::user()->id : ''}}:App\\Events\\NotiEvent", function(message){--}}
            {{--$("#snackbar").html(message.data.message);--}}
            {{--$("#snackbar").addClass('show');--}}
            {{--// After 3 seconds, remove the show class from DIV--}}
            {{--setTimeout(function () {--}}
                {{--$("#snackbar").removeClass('show');--}}
            {{--}, 3000);--}}
        {{--});--}}

        {{--socket.on("haivl-channel.{{\Illuminate\Support\Facades\Auth::user() ? \Illuminate\Support\Facades\Auth::user()->id : ''}}:App\\Events\\UpdateStatus", function(message){--}}
            {{--$("#snackbar").html(message.data.message);--}}
            {{--$("#snackbar").addClass('show');--}}
            {{--// After 3 seconds, remove the show class from DIV--}}
            {{--setTimeout(function () {--}}
                {{--$("#snackbar").removeClass('show');--}}
            {{--}, 3000);--}}
        {{--});--}}
	</script>
@yield('javascript')
<!-- end script -->
</body>
</html>