@extends('layouts.master')
@section('content')
<div id="wrapper" class="toggled">
<div role="navigation" class="wrap-body" id="sidebar-wrapper">
@include('layouts.menu')
<div class="p-20" id="page-content-wrapper">
      <section>
  @include('layouts.sub-menu')
<div class="r">
	<div class="row mt-100">
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
	<div class="row no-margin">
<div class="col-lg-7 col-lg-offset-2 col-md-offset-1 col-sm-offset-2 col-md-9 col-sm-12 col-xs-12">
<div class="panel panel-default">
    <div class="panel-heading"><h4 class="no-margin">Need Support?</h4></div>
    <div class="panel-footer no-bg no-bd">
     <div class="row">
<div class="col-lg-12">
	<div class="single category">
		<ul class="list-unstyled">
			<li >
            <a href="http://api.whatsapp.com/send?phone=+23409062846083"><svg  xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="grey" class="bi bi-whatsapp" viewBox="0 0 16 16">
  <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
</svg> Whatsapp</a>
            </li>
			<li class='p-2'>
            <a href="mailto: customercare@iisysgroup.com"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="grey" class="bi bi-envelope" viewBox="0 0 16 16">
  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
</svg> Email</a>
            </li>
           
			<li class="dropdown" >

          <a href="tel:07080671131">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
              </svg> Telephone</a>      
      </li>			
		</ul>
   </div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
@include('layouts.side-adv')
</div>

</section>
</div>
 
</div>
</div>

@stop


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
<script src="{{ URL::asset('assets/js/slick.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-pincode-input.js') }}"></script>
<script src="{{ URL::asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/wow.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/validator.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/smooth-scroll.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/script.js') }}"></script>

<!-- Initialize Swiper -->

<script>
$(document).ready(function() {
  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });
});
</script>

<script>
function settelco() {
  var telcoimg = document.getElementById("telco_image");
  telcoimg.src =  $('option:selected', this).attr('img');
  return false;
}
document.getElementById("telco_list").onchange = settelco;
</script>    

<script>
function settelco() {
  var telcoimgb = document.getElementById("telco_imageb");
  telcoimgb.src = $('option:selected', this).attr('img');
  return false;
}
document.getElementById("telco_listb").onchange = settelco;
</script>     




<script>
$(document).ready(function() {
  $('#authtopup').hide();
  $('#vtuSwap').hide();
  $('#payMethod').hide();
  $('#showmenu').click(function() {
    $('#authtopup').show("slide");
    $('#topupa').hide();
  });
});  
</script>


<!--Hide Show Utility Bill-->
<script>
$(document).ready(function() {
  $('#billstepone').hide();
  $('#billsteptwo').hide();
  $('#showbill').click(function() {
    $('#billstepone').show("slide");
    $('#billoptionint').hide();
    $('#billoptionutil').hide();
    $('#billoptionother').hide();
	return false;
  });
});  
</script>

<!--Utility Bill Step 2-->
<script>
$(document).ready(function() {
  $('#billsteptwo').hide();
  $('#swapBillAuthForm').click(function() {
    $('#billsteptwo').show("slide");
    $('#billstepone').hide();
  });
});  
</script>

<!--Wallet Transfer Step 1-->
<script>
$(document).ready(function() {
  $('#wallettransferstepone').hide();
  $('#wallettrans').click(function() {
    $('#wallettransferstepone').show("slide");
    $('#hdwallet').hide();
  });
});  
</script>

<!--Wallet Transfer Step 2-->
<script>
$(document).ready(function() {
  $('#wallettransfersteptwo').hide();
  $('#swapWalletAuthForm').click(function() {
    $('#wallettransfersteptwo').show("slide");
    $('#wallettransferstepone').hide();
  });
});  
</script>

<!--Fund Wallet Step 1-->
<script>
$(document).ready(function() {
  $('#walletfundstepone').hide();
  $('#btnfundwallet').click(function() {
    $('#walletfundstepone').show("slide");
    $('#hdwallet').hide();
  });
});  
</script>

<!--Fund Wallet Step 1-->
<script>
$(document).ready(function() {
  $('#linkcardstepone').hide();
  $('#linkedcard').click(function() {
    $('#linkcardstepone').show("slide");
    $('#hdwallet').hide();
  });
});  
</script>

<script>
$(document).ready(function() {
  $('.pincode-input1').pincodeInput({hidedigits:false,complete:function(value, e, errorElement){

    $(".pincode-callback").html("This is the 'complete' callback firing. Current value: " + value);

              // check the code
              if(value!="1234"){
                $(errorElement).html("The code is not correct. Should be '1234'");
              }else{
                alert('code is correct!');
              }
              
            }});
  $('.pincode-input5').pincodeInput({hidedigits:true,inputs:4,placeholders:"0 0 0 0",change: function(input,value,inputnumber){
    $(".pincode-callback2").html("onchange from input number "+inputnumber+", current value: " + value);
  }});

  $('.pincode-input3').pincodeInput({hidedigits:false,inputs:5});


});
</script>








<!--
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
-->





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

  <script type="text/javascript">
  $(document).ready(function(){
    $('.utility-slide').slick({ 
      infinite: true,
      variableWidth: true,
    });
  });
  </script>   
  <script src="{{ URL::asset('js/parsley.min.js') }}"></script>
  <script src="{{ URL::asset('js/sweetalert.min.js') }}"></script>
  <script src="{{ URL::asset('js/jquery.notific8.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/payvice.validate.js') }}"></script>
