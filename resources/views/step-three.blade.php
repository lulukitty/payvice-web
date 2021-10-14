<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="msapplication-tap-highlight" content="no">
<title>Payvice - Airtime Recharge | Pay Utility Bills with ease </title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ URL::asset('assets/css/swiper.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/animate.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/ionicons.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/linea.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/waves.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.notific8.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/parsley.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/owl.carousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/magnific-popup.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">
</head>

<body class="loaded"></body>
	<div id="preloader">
		<div class="loader">
			<img src="{{ URL::asset('assets/img/loader.gif') }}" alt="">
		</div>
	</div>
	<nav class="navbar navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle hidden collapsed" data-toggle="collapse" data-target="#nav-collapse" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
</div>
	</nav>
	<section id="intro" class="main-sectionlog">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-2 col-xs-12 "></div>
				<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 ">
				<div class="text-center mb30"><a href="/"><img class="logo-light" src="{{ URL::asset('assets/img/logo_payvice.png') }}" alt="" /></a></div>
					<ul id="progressbar">
						<li class="active">User Details</li>
						<li class="active">Choose Password</li>
						<li class="active">Transaction PIN</li>
					</ul>

					<div class="panel with-nav-tabs no-border panel-default">
									<div class="panel-body paddfform">
							<div class=" form-group fg-pale text-center">
								<h4 class="ft-w-b">Choose Transaction PIN</h4>
								<p class="medium ft-w-l">Choose a four-digit transaction PIN. You would need this PIN to validate your transaction</p>
							</div>
							@if(Session::has('accessError'))
							<div class="alert alert-danger">
								{{ Session::get('accessError') }}
							</div>
							@endif
							<form action="#" method="post" data-parsley-validate id="completeStepThree">
								<div class=" form-group">
									<input class="form-control" type="password" id="newsletter-email" name="tranpin" placeholder="Enter transaction pin" data-parsley-minlength="4" data-parsley-type="num" id="tranPin" required>
								</div>
								<div class=" form-group">
									<input class="form-control" type="password" id="newsletter-email" name="confirmpin" placeholder="Confirm transaction pin" data-parsley-minlength="4" data-parsley-type="num" data-parsley-equalto="#tranPin" required>
								</div>
								<br/>
								<div class="form-group">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<button href="#" class="btn-custom btn-block arrow-btn waves-effect waves-classic">
										<span class="loginBtn">CREATE ACCOUNT</span>
									<span class="arrow"></span>
								</button>                           
							</div>
						</form>                      
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-2 col-xs-12 "></div>
		</div>
	</div>
</section>

<a href="#" id="back-to-top" title="Back to top">&uarr;</a>  

<script>
(function() {

	var quotes = $(".quotes");
	var quoteIndex = -1;

	function showNextQuote() {
		++quoteIndex;
		quotes.eq(quoteIndex % quotes.length)
		.fadeIn(2000)
		.delay(2000)
		.fadeOut(2000, showNextQuote);
	}

	showNextQuote();

})();

</script>  

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