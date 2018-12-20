<!DOCTYPE html>
<html>
<head>
	<title>CTOGO</title>
	<link href="https://fonts.googleapis.com/css?family=Muli:400,600,700" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

	<style type="text/css">
	#wrapper{
		height: 100%;
		width: 100%;
		position: fixed;
		top: 0;
		left: 0;
		font-family: Muli;
	}
	.row{
		height: 100%;
		max-width: 1440px;
		margin: auto;
	}
	.text{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%,-50%);
		width: 90%;
	}
	.image{
		position: absolute;
		top: 50%;
		left: 50%;
		width: 90%;
		transform: translate(-50%,-50%);
	}
	.image img{
		max-width: 100%;
	}
	.text h1{
		font-size:72px;
		font-weight: bold;
	}
	.text h1 span{
		color: #99cc33;
	}
	.text p{
		font-size: 26px;
		font-style: italic;
	}
	.text p a{
		color: #99cc33;
	}
	#logo{
		position: absolute;
		top: 0;
		left: 50%;
		transform: translateX(-50%);
		height: 100px;
	}
	#logo img{
		max-height: 100%;
	}
</style>
</head>
<body>
	<div id="wrapper" class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-6 col-lg-6">
				<div class="text">
					<h1><span>Ctogo</span> đang trong quá trình bảo trì!</h1>
					<p>Mời bạn ghé thăm trang <a href="http://blog.ctogo.vn">blog</a> của chúng tôi.</p>
				</div>
			</div>

			<div class="col-12 col-md-6 col-lg-6">
				<div class="image">
					<img src="maintainance.png">
				</div>
			</div>
		</div>
	</div>
	<div id="logo"><img src="logo.png"></div>
</body>
</html>