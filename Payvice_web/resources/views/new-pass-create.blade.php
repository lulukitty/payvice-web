<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="msapplication-tap-highlight" content="no">
	<title>Payvice - Airtime Recharge | Pay Utility Bills with ease </title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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
						<div class="mb30"><a href="/"><img class="logo-light" src="../assets/img/logo_payvice.png" alt=""></a></div>
						<div class="panel-body paddfformsmall">

							<form action="#" method="post" id="createNewPasswordUser" data-parsley-validate>
								<div class=" form-group">

									<input class="form-control" type="password" id="password" name="newpassword" placeholder="New Password" required>
								</div>
								<div class=" form-group">

									<input class="form-control" type="password" id="password2" name="password2" placeholder="Repeat New Password" required>
								</div>
								<div class=" form-group">
									<input class="form-control" type="text" id="pin"  pattern="[0-9]{4}" maxlength="4" name="pin" placeholder="New Transaction PIN"  required>
								</div>
								<div class=" form-group">

									<input class="form-control" type="text" id="otp" name="otp" placeholder="Enter OTP Received" required>
								</div>
								<div class="form-group">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									
									<br/>

									<button type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
										<span class="loginBtn">UPDATE PASSWORD</span>
										<span class="arrow"></span>
									</button>
								</div>
							</form>
							<div class="row">
								<div class="col-lg-12 col-md-12 text-center col-sm-12 col-xs-12 "><h6 class="bold"><a class="bold" href="/vice/access">CREATE ACCOUNT</a></h6></div>
							</div>     
						</div>
					</div>


				</div>

				<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 "></div>



			</div>


		</div>

	</section>


	<footer>
		<div class="container">

			<div class="row">

				<div class="col-sm-6">

					<p class="wow fadeInLeft" data-wow-delay=".2s" style="visibility: hidden; animation-delay: 0.2s; animation-name: none;">
						© {{ date('Y') }} PAYVICE.
					</p>

				</div>

				<div class="col-sm-6">

					<ul class="footer-social wow fadeInRight" data-wow-delay=".2s" style="visibility: hidden; animation-delay: 0.2s; animation-name: none;">

						<li>
							<a href="#">
								<i class="ion-social-facebook"></i>
							</a>
						</li>

						<li>
							<a href="#">
								<i class="ion-social-twitter"></i>
							</a>
						</li>

					</ul>

				</div>

			</div>

		</div>
	</footer>




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