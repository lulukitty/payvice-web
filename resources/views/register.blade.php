<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="msapplication-tap-highlight" content="no">
<title>Payvice - Airtime Recharge | Pay Utility Bills with ease </title>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/swiper.css') }}">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/animate.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/ionicons.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/linea.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/waves.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/owl.carousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.notific8.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/parsley.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/magnific-popup.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">

</head>

<body class="loaded">
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
	<section id="intro" class="main-sectionlog parallax">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-2 col-xs-12 "></div>
				<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 ">
				<div class="text-center mb30"><a href="/"><img class="logo-light" src="{{ URL::asset('assets/img/logo_payvice.png') }}" alt="" /></a></div>
					<ul class="no-padding" id="progressbar">
						<li class="active">User Details</li>
						<li>Choose Password</li>
						<li>Transaction PIN</li>
					</ul>
					<div class="panel with-nav-tabs no-border panel-default">
						<form action="#" method="post" data-parsley-validate id="regStepOne">

							<div class="panel-body paddfform">
								<div class=" form-group text-center">
									<h4>Enter User Details</h4>
									<p class="medium">Enter a valid email. Your verification code would be sent to the email</p>
								</div>
								@if(Session::has('accessError'))
								<div class="alert alert-danger">
									{{ Session::get('accessError') }}
								</div>
								@endif

								<div class=" form-group">

									<input class="form-control" type="email" id="newsletter-email" name="email" placeholder="Your Email" data-parsely-type="email" required>

								</div>

								<div class=" form-group">

									<input class="form-control" type="text" id="newsletter-email" name="name" placeholder="Firstname Lastname" required>

								</div>

								<div class="form-group">
									<div class="checkbox checkbox-success">
										<input type="checkbox" class="rel-radio2 marglr10" id="refCheckbox" value="option1">
										<label class="no-padding no-bg" for="refCheckbox"> Have Referral Code? </label>
									</div>
								</div>    

								<br/><br/>
								<div class="form-group">

									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<button type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
										<span class="loginBtn">CHOOSE A PASSWORD</span> 
									<span class="arrow"></span>
								</button>                           
							</div>  
						</div>
					</form>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-2 col-xs-12 "></div>
		</div>


	</div>

</section>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialogb" role="document">
		<div class="modal-content">
			<div class="modal-body">
			<div class="mb30">
			<h4 class="modal-title inline" id="exampleModalLabel">Referrer's Code</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>				
				<div class=" form-group">
					<input class="form-control" type="text" id="newsletter-email" name="super" placeholder="Enter Referrer Code">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				</div>
			</div>
			<div class="modal-footer no-bd">
				<div class="form-group">
					<button class="btn-customb btn-block arrow-btn waves-effect waves-classic" id="verifyRef">
						VERIFY CODE
					<span class="arrow"></span>
				</button>                           
			</div>
		</div>
	</div>
</div>
</div>



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
$('input[id="refCheckbox"]').on('change', function(e){
	if(e.target.checked){
		$('#myModal').modal({
			backdrop: false,
			keyboard: false
		});
	}
});
</script>

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