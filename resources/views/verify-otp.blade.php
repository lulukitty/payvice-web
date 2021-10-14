<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="msapplication-tap-highlight" content="no">

<title>Payvice - Airtime Recharge | Pay Utility Bills with Ease </title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/swiper.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/animate.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/ionicons.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/linea.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/waves.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.notific8.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/parsley.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/owl.carousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/magnific-popup.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">
</head>

<body class="loaded main-sectionlog">
	<section id="intro" class="min-heightbb parallax">
		<div class="container">
			<div class="space"></div>
			<div class="row">
				<div class="col-lg-4 col-md-3 col-sm-2 col-xs-12 "></div>
				<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12 ">
					<div class="panel with-nav-tabs text-center no-border">
					<div class="mb30"><a href="/"><img class="logo-light" src="{{ URL::asset('assets/img/logo_payvice.png') }}" alt=""></a></div>
						<div class="panel-body paddfformsmall">
							<form action="#" method="post" id="payviceVerifyOtp" data-parsley-validate>                                
                                <h6>Enter OTP sent to your Mail or Phone</h4>
								<div class=" form-group">
								<i class="ion-locked fstylec"></i>
									<input class="form-control" type="password" id="otp" name="otp" placeholder="Enter OTP" required>
								</div>
								{{-- <div class=" form-group">
								<i class="ion-locked fstylec"></i>
									<input class="form-control" type="password" id="newsletter-email" name="password" placeholder="Password" required>
                                </div> --}}
								<div class="form-group">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<br/>
									<button type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
										<span class="loginBtn">VERIFY</span>
									<span class="arrow"></span>
								</button>
								</div>
							</form>
							<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h6 class="bold"><a href="/vice/my-pass">Recover Password</a></h6></div>
							<div class="col-lg-6 col-md-6 text-right-rs col-sm-6 col-xs-6 "><h6 class="bold"><a class="bold" href="/vice/access">Create Account</a></h6></div>
						</div>
					</div>	
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 "></div>
		</div>
	</div>
</section>

<script src="{{ URL::asset('assets/js/swiper.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/parallax.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/particles.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/waves.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/wow.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/validator.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/smooth-scroll.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/script.js') }}"></script>
<script src="{{ URL::asset('js/parsley.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.notific8.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/payvice.validate.js') }}"></script>
</body></html>