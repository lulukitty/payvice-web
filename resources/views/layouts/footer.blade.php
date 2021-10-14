
<div id="myReferrall" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Referral</h4>
        <p class="no-margin fg-pale">Earn N100 when you refer your friends and family</p>
      </div>
      <div class="modal-body">
       <h3 class="text-center">Referral Code : <span class="text-success">57571362</span></h3>
     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
    </div>
  </div>

</div>
</div>

<div class="row no-margin">
  <div class="col-lg-12">
    <p style="position:absolute; bottom:0px; left:50%" class="small text-center"> &copy; <script>document.write(new Date().getFullYear()) </script> Itex Integrated Services &nbsp;&nbsp; V.2.8.5</p>
  </div>
</div>
<div id="stlivechat0"></div>
<a href="#" id="back-to-top" title="Back to top"><i class="ion-ios-arrow-thin-up updirect"></i></a>

<script>
  document.getElementById('app').style['display'] = 'none';


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
  $( document ).ready(function() {
    //get the section name from hash
    var sectionName = window.location.hash.slice(1);
//then show the section
$('#' + sectionName ).show(); 
if($(window).width()<767){
  $('#wrapper').removeClass('toggled');
}else{
  $('#wrapper').addClass('toggled');
}
});


  $(window).resize(function(){
    if($(window).width()<767){
      $('#wrapper').removeClass('toggled');
    }else{
      $('#wrapper').addClass('toggled');
    }
  });

</script>

<script src="{{ URL::asset('assets/js/swiper.min.js') }}"></script>
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
<script src="{{ URL::asset('js/jquery.blockUI.js') }}"></script>
<script src="{{ URL::asset('assets/js/script.js') }}"></script>
<script src="{{ URL::asset('assets/js/action-script.js') }}"></script>

<script src="{{ URL::asset('assets/js/jquery.scrollbar.min.js') }}"></script>
<script src="{{ URL::asset('js/parsley.min.js') }}"></script>
<script src="{{ URL::asset('js/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.notific8.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/payvice.validate.js') }}"></script>
<script src="{{ URL::asset('assets/js/toastr/toastr.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/ajax.js') }}" type="text/javascript"></script>
<script type="text/javascript" src = "{{asset('js/bootstrap-datepicker.min.js')}}"></script>

{{-- Push scripts into this block from other views --}}
@stack('scripts')
{{-- Push scripts into this block from other views --}}
<!-- Initialize Swiper -->

<script>      
  (function($){
   $(window).on("load",function(){
    $(".wrap-body").mCustomScrollbar({
     theme:"minimal"
   });

  });
 })(jQuery);
</script>


<script>
  $(document).ready(function() {

    /** Balane Carousel**/
    $('.owl-carousel').owlCarousel({
      loop:true,
      margin:10,
      nav:true,
      responsive:{
        0:{
          items:1
        },
        600:{
          items:1
        },
        1000:{
          items:1
        }
      }
    });

    $('[data-toggle=offcanvas]').click(function() {
      $('.row-offcanvas').toggleClass('active');
    });
  });
</script>

<!--
<script>
function settelco() {
  var telcoimg = document.getElementById("telco_image");
  telcoimg.src =  $('option:selected', this).attr('img');
  return false;
}
document.getElementById("telco_list").onchange = settelco;
</script>
document.getElementById('splash').style['display'] = 'block';
-->

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
      $('#authtopup').fadeIn("slow");
      $('#topupa').hide();
    });
  });
</script>

<!--Utility Bill Step 2-->
<script>
  $(document).ready(function() {
    $('#billsteptwo').hide();
    $('#swapBillAuthForm').click(function() {
      $('#billsteptwo').fadeIn("slow");
      $('#billstepone').hide();
      $('#payMethod').hide();
    });
  });
</script>

<!--Utility Bill Step 3-->
<script>
  $(document).ready(function() {
    $('#billsteptwo').hide();
    $('#pinProceed').click(function() {
      $('#payMethod').fadeIn("slow");
      $('#billsteptwo').hide();
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

    $(document).on('submit', '#walletTransferStepOne', function(event) {
      event.preventDefault();

      if ($("#walletTransferStepOne input").val() != "") {
        $("#walletOneProceed").html('<i class="fa fa-spin fa-spinner"></i> CONNECTING...');
        $.ajax({
          url: '/tran/w2w/1',
          type: 'POST',
          dataType: 'json',
          data: {
            toWallet : $('input[name=ToWallet]').val(),
            amount : $('input[name=toWalletAmount]').val(),
            _token: $('input[name=_token]').val()
          },
          success: function(data){
            $("#walletOneProceed").html('PROCEED');
            if (data['status'] == 0) {
              $('#wallettransferstepone').hide();
              $('#wallettransfersteptwo').show("slide");
            };
          }
        });
      }else{
        swal("Wallet Transfer", "Please field all required fileds", "error");
      }
      
    });

    $(document).on('click', '#pinProceed', function(event) {
      event.preventDefault();

      if ($("#idPinWall").val() != "") {
        $("#walletTwoProceed").html('<i class="fa fa-spin fa-spinner"></i> CONNECTING...');
        $.ajax({
          url: '/tran/w2w/2',
          type: 'POST',
          dataType: 'json',
          data: {
            pin : $('input[name=tranPin]').val(),
            _token: $('input[name=_token]').val()
          },
          success: function(data){
            $("#walletTwoProceed").html('PROCEED');
            if (data['status'] == 0) {
              swal("Wallet Transfer", "Completed successfully", "success");
              setTimeout(function() {
                location.reload();
              }, 2000);
            }else{
              swal("Wallet Transfer", data['msg'], "error");
            };
          }
        });
      }else{
        swal("Wallet Transfer", "Please enter your transaction pin", "error");
      }
      
    });


  });  
</script>

<!--Close Wallet Transfer-->
<script>
  $(document).ready(function() {
  //$('#wallettransferstepone').hide();
  $('#closewallet').click(function() {
    $('#hdwallet').show("slide");
    $('#wallettransferstepone').hide();
  });
});  
</script>

<!--Close Wallet Transfer-->
<script>
  $(document).ready(function() {
  //$('#wallettransferstepone').hide();
  $('#closewallet').click(function() {
    $('#hdwallet').fadeIn("slow");
    $('#wallettransferstepone').hide();
  });
});
</script>

<!--Fund Wallet Step 1-->
<script>
  $(document).ready(function() {
    $('#walletfundstepone').hide();
    $('#btnfundwallet').click(function() {
      $('#walletfundstepone').fadeIn("slow");
      $('#hdwallet').hide();
    });
  });
</script>

<!--Fund Wallet Step 1-->
<script>
  $(document).ready(function() {
 // $('#walletfundstepone').hide();
 $('#closefundwallet').click(function() {
  $('#hdwallet').fadeIn("slow");
  $('#walletfundstepone').hide();
});
});
</script>




<!--Linked Card Step 1-->
<script>
  $(document).ready(function() {
    $('#linkcardstepone').hide();
    $('#linkedcard').click(function() {
      $('#linkcardstepone').fadeIn("slow");
      $('#hdwallet').hide();
    });
  });
</script>


<!--Close Linked Card-->
<script>
  $(document).ready(function() {
  //$('#linkcardstepone').hide();
  $('#closelinkcard').click(function() {
    $('#hdwallet').fadeIn("slow");
    $('#linkcardstepone').hide();
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
      e.preventDefault();
      $('html,body').animate({
        scrollTop: 0
      }, 700);
    });
  }
</script>

<script type="text/javascript">
  $(document).ready(function(){
 /**
   $('.utility-slide').slick({
      infinite: false,
      variableWidth: true,
    });
    **/

    setTimeout(function() {
      $('.agentLoader').block({
        message: '<div class="blockui-default-message"><i class="fa fa-spinner fa-spin"></i> Loading Agents</div>',
        overlayCSS:  {
          background: 'rgba(0, 151, 219, 0.8)',
          opacity: 1,
          cursor: 'wait'
        },
        css: {
          width: 'auto'
        },
        blockMsgClass: 'block-msg-message-loader'
      });


      $.ajax({
        url: '/tran/getAgentListDetails',
        type: 'GET',
        dataType: 'html',
        data: {id: $('input[name="wallID"]').val()},
        success: function(html){
          $('.eachAgent').html(html);
          $('.agentLoader').unblock();
        }
      });

    }, 1000);
  });
</script>

<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  $(document).on('click', 'a[data-agent]', function() {

    var walletID = $(this).attr("data-agent"), agentEmail = $(this).attr("data-email");


    $('.center-panel').block({
      message: '<div class="blockui-default-message"><i class="fa fa-spinner fa-spin"></i> Loading Agent Transactions</div>',
      overlayCSS:  {
        background: 'rgba(0, 151, 219, 0.8)',
        opacity: 1,
        cursor: 'wait'
      },
      css: {
        width: 'auto'
      },
      blockMsgClass: 'block-msg-message-loader'
    });

    $.ajax({
      url: '/tran/get-agent-tran',
      type: 'GET',
      dataType: 'html',
      data: {id: walletID, email: agentEmail},
      success: function(data){
        $('.loadSearch').html(data);
        $('.center-panel').unblock()
      }
    });
    return false;
  });
</script>  
<script type="text/javascript"> window.$crisp=[];window.CRISP_WEBSITE_ID="8dedb9a6-dd04-4525-ab3b-dff1eb4368d1";(function(){ d=document;s=d.createElement("script"); s.src="https://client.crisp.chat/l.js"; s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})(); </script>
@yield('commissionTransferScripts')
  {{-- <script type="text/javascript"> window.$crisp=[];window.CRISP_WEBSITE_ID="8dedb9a6-dd04-4525-ab3b-dff1eb4368d1";(function(){ d=document;s=d.createElement("script"); s.src="https://client.crisp.chat/l.js"; s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})(); </script>
<script>

  $( window).on( "load", function() {
    document.getElementById('app').style['display'] = 'block';
  });

</script>

<script type="text/javascript">

  (function() {

    var c = document.createElement('script');

    c.type = 'text/javascript'; c.async = true;

    //c.src = "http://197.253.19.78:9996/ChatLink.ashx?config=2&id=stlivechat0";
    c.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + "crm.itexapp.com/ChatLink.ashx?config=2&id=stlivechat0";
    var s = document.getElementsByTagName('script')[0];

    s.parentNode.insertBefore(c,s);

  })();

</script>

</body>
</html>