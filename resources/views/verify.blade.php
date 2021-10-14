<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->


<!-- Remove Tap Highlight on Windows Phone IE -->
<meta name="msapplication-tap-highlight" content="no">


<title>Payvice - Airtime Recharge | Pay Utility Bills with ease </title>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/swiper.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/animate.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/ionicons.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/linea.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.notific8.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/parsley.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/waves.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/owl.carousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/magnific-popup.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">
<style>
.swiper-container {
	/* width: 100%;*/
	width:270px;
	height: 100%;
	background-image: url({{ URL::asset('assets/img/mockup4.png') }});
	height: 550px;
	background-size: contain;
}
.swiper-slide {
	text-align: center;
	font-size: 18px;

	/* Center slide text vertically */
	display: -webkit-box;
	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	-webkit-justify-content: center;
	justify-content: center;
	-webkit-box-align: center;
	-ms-flex-align: center;
	-webkit-align-items: center;
	align-items: center;
}

</style>
</head>

<body class="loaded"><div class="" style="z-index: -100; position: fixed; top: 0px; left: 0px; overflow: hidden; height: 620px; width: 1349px; transform: translate3d(0px, 0px, 0px);"><img class="" src="{{ URL::asset('assets/img/bg.jpg') }}" style="transform: translate3d(0px, 0px, 0px); position: absolute; left: 0px; height: 900px; width: 1349px; max-width: none;"></div><div class="" style="visibility: hidden; z-index: -100; position: fixed; top: 0px; left: 0px; overflow: hidden; transform: translate3d(0px, 0px, 0px); height: 538px; width: 1349px;"><img class="" src="{{ URL::asset('assets/img/bg-mockup.jpg') }}" style="transform: translate3d(0px, 0px, 0px); position: absolute; left: 0px; height: 835px; width: 1349px; max-width: none;"></div><div class="parallax-mirror" style="visibility: visible; z-index: -100; position: fixed; top: 0px; left: 0px; overflow: hidden; transform: translate3d(0px, 0px, 0px); height: 913px; width: 1349px;"></div>


	<div id="preloader">
		<div class="loader">
			<img src="{{ URL::asset('assets/img/loader.gif') }}" alt="">
		</div>
	</div>



	<nav class="navbar navbar-fixed-top">

		<div class="container">


			<div class="navbar-header">


				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-collapse" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>


				<a href="#" class="navbar-brand">
					<img class="logo-light" src="{{ URL::asset('assets/img/logo.png') }}" alt="">
					<img class="logo-dark" src="{{ URL::asset('assets/img/logo-dark.png') }}" alt="">
				</a>

			</div>



			<div class="collapse navbar-collapse" id="nav-collapse">
				<ul class="nav navbar-nav hidden navbar-right">
					<li><a class="btn-customb" href="/vice/connect" data-scroll="">Use PAYVICE Web<span class="arrow"></span></a></li>

				</ul>
				<ul class="nav navbar-nav hidden navbar-right">

					<li class="active">
						<a href="#intro" data-scroll="">home</a>
					</li>

					<li class="">
						<a href="#features" data-scroll="">Features</a>
					</li>

					<li class="">
						<a href="#pricing" data-scroll="">how it work</a>
					</li>

					<li>
						<a href="#downloads" data-scroll="">download</a>
					</li>



				</ul>

				
			</div>

		</div>

	</nav>








	<section id="intro" class="main-sectionlog  min-height parallax">

		<div class="particle-bg" id="particles"><canvas class="particles-js-canvas-el" width="1349" height="913" style="width: 100%; height: 100%;"></canvas></div>


		<div class="container">

			<div class="space"></div>
			<div class="row">


				<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 "></div>

				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">



					<div class="panel big_shadow with-nav-tabs no-border panel-default">
						
                        
                        <div class="panel-heading">

						<div class=" form-group text-center">
							<h4 class="fg-green bold">{{ Session::get('userEmail') }}</h4>
							<p class="medium">A verification code has been sent to your supplied email address. Please check your Inbox or Spam for your verification code</p>
						</div>



					</div>
                        
						<div class="panel-body paddfformsmall">

							<form action="#" method="post" id="finalCompletionStep" data-parsley-validate>
								<div class=" form-group">

									<input class="form-control" type="text" id="newsletter-email" name="verificCode" placeholder="Enter Verification Code" required>

								</div>

								<br/>    

								<div class="form-group">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<button type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
										<span class="loginBtn">COMPLETE REGISTRATION</span>
									<span class="arrow"></span>
								</button>                            

							</form>

						</div>                      

					</div>
					

				</div>


			</div>

			<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 "></div>



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


<!-- Initialize Swiper -->



<script>
var swiper = new Swiper('.swiper-container', {
	pagination: '.swiper-pagination',
	nextButton: '.swiper-button-next',
	prevButton: '.swiper-button-prev',
	paginationClickable: true,
	spaceBetween: 30,
	centeredSlides: true,
	autoplay: 2500,
	autoplayDisableOnInteraction: false
});
</script> 

<script>
if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
    backToTop = function () {
    	var scrollTop = $(window).scrollTop();
    	if (scrollTop > scrollTrigger) {
    		$('#back-to-top').addClass('show');
    	} else {
    		$('#back-to-top').removeClass('show');
    	}
    };
    backToTop();
    $(window).on('scroll', function () {
    	backToTop();
    });
    $('#back-to-top').on('click', function (e) {
    	e.preventDefault();
    	$('html,body').animate({
    		scrollTop: 0
    	}, 700);
    });
}

</script>


</body></html>