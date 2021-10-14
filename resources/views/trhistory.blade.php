@extends('layouts.master')
@section('content')

<div id="wrapper" class="toggled" >
 <div role="navigation" class="wrap-body" id="sidebar-wrapper">
 @include('layouts.menu')
 <div class="p-20" id="page-content-wrapper">
      <section>
      @include('layouts.sub-menu')
      <div class="row mt-100">
                 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                 <div class="row">
<div class="col-lg-10 col-lg-offset-1 col-md-offset-1 col-md-10 col-sm-12 col-xs-12">
<div class="panel panel-default">
    <div class="panel-heading"><h4 class="no-margin">Transaction History</h4></div>



    <div class="panel-footer no-bd">
     <div class="row">



      <div class="col-lg-12">
        <div class="col-lg-8"><p class="medium margp text-danger">Purchase </p></div>
        <div class="col-lg-4"><p class="medium text-right margp text-success">08706645635634 </p></div>
      </div>

      <div class="col-lg-12 bg-white">
       <div class="col-lg-12"><p class="medium no-margin">GOTV TOP UP</p></div>

       <div class="col-lg-8"><h4 class="bold fg-pale">N 500.00 </h4></div>
       <div class="col-lg-4"><p class="text-right text-success"><button class="btn btn-block btn-customd" >repeat</button> </p></div>


       <div class="col-lg-6"><p class="medium">9868767567596563 </p></div>
       <div class="col-lg-6"><p class="text-right medium text-success">
         2017 - April - 18 09-04-15
       </p></div>
     </div>




     <div class="col-lg-12">
      <div class="col-lg-8"><p class="medium margp text-danger">Purchase </p></div>
      <div class="col-lg-4"><p class="medium text-right margp text-success">08706645635634 </p></div>
    </div>

    <div class="col-lg-12 bg-white">
     <div class="col-lg-12"><p class="medium no-margin">GOTV TOP UP</p></div>

     <div class="col-lg-8"><h4 class="bold fg-pale">N 500.00 </h4></div>
     <div class="col-lg-4"><p class="text-right text-success"><button class="btn btn-block btn-customd" >repeat</button> </p></div>


     <div class="col-lg-6"><p class="medium">9868767567596563 </p></div>
     <div class="col-lg-6"><p class="text-right medium text-success">
       2017 - April - 18 09-04-15
     </p></div>
   </div>




   <div class="col-lg-12">
    <div class="col-lg-8"><p class="medium margp text-danger">Purchase </p></div>
    <div class="col-lg-4"><p class="medium text-right margp text-success">08706645635634 </p></div>
  </div>

  <div class="col-lg-12 bg-white">
   <div class="col-lg-12"><p class="medium no-margin">GOTV TOP UP</p></div>

   <div class="col-lg-8"><h4 class="bold fg-pale">N 500.00 </h4></div>
   <div class="col-lg-4"><p class="text-right text-success"><button class="btn btn-block btn-customd" >repeat</button> </p></div>


   <div class="col-lg-6"><p class="medium">9868767567596563 </p></div>
   <div class="col-lg-6"><p class="text-right medium text-success">
     2017 - April - 18 09-04-15
   </p></div>
 </div>




</div>

</div>


</div>
</div>
</div>  
                
                </div>
                 </div>  

</section>
</div>
  

</div>

</div>

@stop











</div><!-- /.col-xs-12 main -->
</div><!--/.row-->
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









































