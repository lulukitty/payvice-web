@extends('layouts.master')
@section('content')

<div id="wrapper" class="toggled" >
     <!-- Sidebar -->
<div role="navigation" class="wrap-body" id="sidebar-wrapper">
@include('layouts.menu')
<div class="p-20" id="page-content-wrapper">
<section>
@include('layouts.sub-menu')
<div class="row mt-100">
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
<div class="row no-margin">
<div class="col-lg-7 col-lg-offset-2 col-md-offset-2 col-md-8 col-sm-12 col-xs-12 padded-area">

  <div class="" id="2b">

      <form  id="payData" data-parsley-validate>
        <div class="data_stepone" id="topupForm">
        <div class="mb-30">
                              <h4 class="inline mt-0">Buy Data</h4>  
                                <span class="pull-right">
                                <img id="telco_imageb" class="rounded-ic" src="{{ URL::asset('assets/img/null_img.png') }}" />
                                </span> 
                              </div>
          <br/>
          <div class=" form-group">
                <i class="ion-android-phone-portrait fstylec"></i>
              <select id="telco_listb" placeholder="Select Mobile Network" class="form-control" required name="network">
                <option value="" img="{{ URL::asset('assets/img/null_img.png') }}">Select Mobile Network</option>
                <option value="MTNDATA" img="{{ URL::asset('assets/img/mtn_img.png') }}">MTN</option>
                <option value="GLODATA" img="{{ URL::asset('assets/img/glo_img.png') }}">GLO</option>
                <option value="ETISALATDATA" img="{{ URL::asset('assets/img/etisalat_img.png') }}">ETISALAT</option>
                <option value="AIRTELDATA" img="{{ URL::asset('assets/img/airtel_img.png') }}">AIRTEL</option>
              </select>
         </div>

         <div id="responseDiv">

        </div>

        <div class="form-group">

          <button type="submit" id="swapBtnForm" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
            PROCEED
          <span class="arrow"></span>
        </button>
      </div>
    </div>

    <div id="DataResponse">
      <div id="vtuSwap" class="data_steptwo" style="display:none:">
      <a id="backdatasteptwo" class="btn abs-left no-bd btn-default waves-effect waves-light"> <i class="fa m-0 fa-arrow-left"></i></a>
          <div class="text-center mb-50">
              <div class="authimg">
              <img style="margin: 20px auto;" src="{{ URL::asset('assets/img/password.svg') }}">
              </div>
              <h4>Your 4 Digit PIN</h4>
              <P class="medium">This is your personal digit PIN needed to complete this transaction</P>
          </div>
              <div class=" form-group">
              <input type="text" style="margin:0px auto" class="pincode-input5"  name="pin" >
              </div>
              <br>
          <input type="hidden" name="view" value="{{ rand() }}" />

          <div class="form-group">
            <button type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
              <span class="payBtn">PROCEED</span>
            <span class="arrow"></span>
          </button>
          </div>

      </div>
  </div>

</form>
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

@push('scripts')
<script>
$('select').on('change', function() {
    var data = this.value;
    updateDom("{{ route('mobileDataLookup') }}?service="+data+"&view=1", 'responseDiv', 'Fetching Data Plans');
});

  // Submit payData Form
  $("#payData").submit(function (e) {
        e.preventDefault();
        var spintext = 'Processing Subscription Request';
        submit_form('payData', "{{ route('paySubscription') }}", spintext, 'DataResponse', false, false);
  });


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
      //e.preventDefault();
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

<script>
    document.getElementById('app').style['display'] = 'block';
    document.getElementById('splash').style['display'] = 'none';
</script>
@endpush
