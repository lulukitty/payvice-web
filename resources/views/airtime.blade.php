@extends('layouts.master')
@section('content')

<div id="wrapper" class="toggled" >

     <!-- Sidebar -->
        <div role="navigation" id="sidebar-wrapper">


		     <!-- sidebar -->

     <div>
      <div class="site-logo">
         <a href="/tran">
          <img class="logo-light" src="{{ URL::asset('assets/img/logo.png') }}" alt="">
        </a>
      </div>




 @include('layouts.menu')

  <div id="page-content-wrapper">
  <a href="#" class="btn bg-paleb-opac fixedtop ztop btn-default navbar-toggle block pull-left" id="menu-toggle"><span class="icon-bar"></span>
       <span class="icon-bar"></span>
       <span class="icon-bar"></span></a>



   <div class="row">
   <div class="col-lg-12">

   <div class="particle-bg" id="particles"><canvas class="particles-js-canvas-el" width="1349" height="913" style="width: 100%; height: 100%;"></canvas></div>



  <div class="paddlr10">
    <div class="row row-offcanvas row-offcanvas-left">

      <!-- sidebar -->
<!--      <div class="col-xs-6 col-lg-2 col-md-3 col-sm-3 no-padding min-heightb sidebar-offcanvas" id="sidebar" role="navigation">




   <div id="site-logo"><a href="/tran" alt="Payvice Logo"> <img src="{{ URL::asset('assets/img/profle-512.png') }}" /></a></div>

      <div class="text-center margtb20">
        <h4 class="text-center bold fg-white">{{ Session::get('curUsr') }}</h4>
      </div>


      <ul class="nav sidelist">
        <li class="active"><a href="airtime"><i class="ion-ipad fstyle"></i>Airtime Top-up</a></li>
        <li><a href="paybills"><i class="ion-ios-paper-outline fstyle"></i>Pay Bills</a></li>
        <li><a href="trhistory"><i class="ion-android-list fstyle"></i>Transaction History</a></li>
        <li><a href="#"><i class="ion-android-people fstyle"></i>Refer a Friend</a></li>
        <li><a href="settings"><i class="ion-android-settings fstyle"></i>Settings</a></li>
        <li><a href="/vice/disconnect"><i class="ion-android-exit fstyle"></i>Log out</a></li>
      </ul>

    </div>
 -->
    <!-- main area -->
    <div class="col-xs-12 col-lg-12 min-height col-md-12 col-sm-12">



<section class="paddsection-resp no-bg">
<div class="particle-bg" id="particles"><canvas class="particles-js-canvas-el" width="1349" height="913" style="width: 100%; height: 100%;"></canvas></div>

  <div class="row">

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

  <div class="panel no-bg no-bd panel-default margalt">
              <div class="panel-body no-padding no-bg">
                <div class="row">
                  <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">

                    <div class="text-center row" data-toggle="buttons">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                        <label href="#2b" data-toggle="tab" style="display:block" class="btn  btn-custombd btn-circle active"> 
                        <input type="radio" class="rel-radio" name="q1" value="1" checked >Airtime VTU</label>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> <!-- 1b --><label href="#" data-toggle="tab" style="display:block" class="btn  btn-custombd btn-circle disabled" ><input type="radio" class="rel-radio" name="q1" value="0">Airtime PIN</label></div>

                    </div>

                    <div class="tab-content margalt clearfix">
                      <div class="tab-pane active" id="2b">
                       <div class="panel panel-default">

                        <div class="panel-body">
                          <form action="#" method="post" id="payAirtime" data-parsley-validate>
                            <div id="topupForm">

                              <br/>
                              <div class=" form-group">
                                <div class="input-group">
                                  <div class="input-group-addon no-padding no-bg no-bd">

                                    <i class="ion-android-phone-portrait fstylec"></i>

                                  </div>
                                  <select id="telco_listb"  placeholder="select mobile network" class="form-control" required name="network">

                                    <option value="" img="{{ URL::asset('assets/img/null_img.png') }}">select mobile network</option>
                                    <option value="MTN" img="{{ URL::asset('assets/img/mtn_img.png') }}">MTN</option>
                                    <option value="GLOVTU" img="{{ URL::asset('assets/img/glo_img.png') }}">GLO</option>
                                    <option value="ETST" img="{{ URL::asset('assets/img/etisalat_img.png') }}">9MOBILE</option>
                                    <option value="AIRT" img=" {{ URL::asset('assets/img/airtel_img.png') }}">AIRTEL</option>
                                  </select>

                                  <div style="width:30px" class="input-group-addon no-padding no-bg no-bd">
                                   <img id="telco_imageb" src="{{ URL::asset('assets/img/null_img.png') }}" />
                                 </div>

                               </div>
                             </div>



                             <div class=" form-group">
                              <div class="input-group">
                                <div class="input-group-addon no-padding no-bg no-bd">
                                  <i class="ion-android-call fstylec"></i>
                                </div>
                                <input placeholder="ENTER PHONE NUMBER" class="form-control" type="number" required min="11" name="phone">
                              </div>
                            </div>

                            <div class=" form-group">
                              <div class="input-group">
                                <div class="input-group-addon no-padding no-bg no-bd">
                                  <span class="fstylec">&#8358;</span>
                                </div>
                                <input class="form-control" type="number" id="newsletter-email" name="amount" placeholder="ENTER AMOUNT" required>

                              </div>
                            </div>
                            <br/>

                            <div class="form-group">

                              <button type="submit" id="swapBtnForm" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                                PROCEED
                              <span class="arrow"></span>
                            </button>
                          </div>

                        </div>

                        <div id="vtuSwap" class="panel panel-default">
                          <div class="panel-body text-center">
                            <div class="authimg">
                              <img src="{{ URL::asset('assets/img/screen.png') }}">
                            </div>


                            <h4>Your 4 Digit PIN</h4>
                            <P class="medium">This is your personal digit PIN needed to complete this transaction</P>
                          </div>
                          <div class="panel-footer no-bd">
                            <div class=" form-group">

                              <input type="text" style="margin:0px auto" class="pincode-input5"  name="pin" >


                            </div>

                            <br>
                            <div class="form-group">
                              <button id="pinProceed" type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                                <span class="payBtn">PROCEED</span>
                              <span class="arrow"></span>
                            </button>
                          </div>

                        </div>
                      </div>
                      <div id="payMethod" class="panel panel-default">

                       <div class="panel-heading text-center">
                         <p class="fg-blue">Wallet Ballance</p>
                         <h1 class="bold no-margin fg-green">{{ $balance }}</h1>
                         <h6 class="fg-blue">Wallet ID : {{ Session::get('curAcc') }}</h6>
                       </div>
                       <div class="panel-body text-center">
                        <ul class="list-group shadow">

                          <li class="list-group-item">
                            <label class="radio labelchk no-margin no-bg"><input type="radio" class="rel-radioright" name="payMethod"><spam class="imgchkk"><img src="{{ URL::asset('assets/img/payvice_logob.png') }}" /></spam>   USE PAYVICE WALLET</label>
                          </li>
                          <li class="list-group-item">
                            <label class="radio labelchk no-margin no-bg"><input type="radio" class="rel-radioright" name="payMethod" disabled ><spam class="imgchkk"><img src="{{ URL::asset('assets/img/credit_card_link.png') }}" /></spam>   USE LINKED CARD(S)</label>
                          </li>
                          <li class="list-group-item">
                            <label class="radio labelchk no-margin no-bg"><input type="radio" class="rel-radioright" name="payMethod" disabled ><spam class="imgchkk"><img src="{{ URL::asset('assets/img/debit_credit_card.png') }}" /></spam>   DEBIT/CREDIT CARD</label>
                          </li>

                        </ul>
                      </div>
                      
                      <div class="panel-footer no-bd">
                          <center><div class="payProcess" style="text-align: center; margin-top: -20px; margin-bottom: 10px;"></div></center>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button id="showmenu" type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                          <span class="payBtnLst">MAKE PAYMENT</span>
                        <span class="arrow"></span>
                      </button>

                    </div>
                  </div>


                </form>
              </div>

            </div>
          </div>




          <div class="tab-pane" id="1b">

            <div class="panel panel-default">

              <div class="panel-body">

               <br/>

               <div id="topupa">
                 <div class=" form-group">
                  <div class="input-group">
                    <div class="input-group-addon no-padding no-bg no-bd">
                      <i class="ion-android-phone-portrait fstyle"></i>
                    </div>



                    <select id="telco_list"  placeholder="select mobile network" class="form-control">

                      <option value="" img="{{ URL::asset('assets/img/null_img.png') }}">SELECT MOBILE NETWORK</option>
                      <option value="MTN" img="{{ URL::asset('assets/img/mtn_img.png') }}">MTN</option>
                      <option value="GLOVTU" img="{{ URL::asset('assets/img/glo_img.png') }}">GLO</option>
                      <option value="ETST" img="{{ URL::asset('assets/img/etisalat_img.png') }}">ETISALAT</option>
                      <option value="AIRT" img="{{ URL::asset('assets/img/airtel_img.png') }}">AIRTEL</option>
                    </select>


                    <div style="width:30px" class="input-group-addon no-padding no-bg no-bd">
                     <img id="telco_image" src="{{ URL::asset('assets/img/null_img.png') }}" />
                   </div>

                 </div>
               </div>
               <div class=" form-group">
                <div class="input-group">
                  <div class="input-group-addon no-padding no-bg no-bd">
                   <span class="fstyle">₦</span>
                 </div>

                 <select placeholder="select the pin amount" class="form-control">
                   <option value="">SELECT PIN AMOUNT?</option>
                   <option value="100">N100</option>
                   <option value="200">N200</option>
                   <option value="400">N400</option>
                   <option value="500">N500</option>
                   <option value="1000">N1000</option>
                   <option value="1500">N1500</option>
                 </select>

               </div>
             </div>
             <div class=" form-group">
              <div class="input-group">
                <div class="input-group-addon no-padding no-bg no-bd">
                  <i class="ion-grid fstyle"></i>
                </div>
                <input class="form-control" type="email" id="newsletter-email" name="EMAIL" placeholder="how many pins">


              </div>
            </div>

          </div>


          <div id="authtopup" class="panel panel-default">
            <div class="panel-heading">
              <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <p class="no-margin"> Network Option</p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <p class="no-margin">GLO TVU</p>
                </div>
              </div>



            </div>
              <div class="panel-body bg-paleb">
                <div class="row">
                  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <p class="no-margin">Phone</p>
                  </div>

                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <p class="no-margin">08076655459</p>
                  </div>
                </div>
              </div>
              <div class="panel-footer no-bd no-bg">
                <div class=" form-group">
                  <input class="form-control" type="email" id="newsletter-email" name="EMAIL" placeholder="amount">

                </div>

                <div class=" form-group">
                  <input class="form-control" type="email" id="newsletter-email" name="EMAIL" placeholder="enter transaction pins">

                </div>

              </div>
            </div>


            <br/>

            <div class="form-group">

              <button id="showmenu" href="#" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                PROCEED
              <span class="arrow"></span>
            </button>

                  </div>
                </div>

              </div>


            </div>

          </div>

          </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                  <div role="tabpanel" class="tab-pane" >
                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default margalt">
                          <div class="panel-heading">Recent Transaction</div>
                          <div class="panel-body">
                            <div class="row">
                              <?php
                                $i = 0;
                              ?>
                              @foreach($hist as $tran)
                              <?php
                              $i++;
                              $det = explode('|', $tran);

                              if (!empty($det) && count($det) > 1):

                                if (strpos( $det[0], 'Payment with Terminal') !== false && strpos( $det[3], 'ServiceChrgTx') === false){
                                  $type = explode('with', $det[0]);

                                  ?>
                                  <div block="">
                                    <div class="col-lg-12 bdtop bdbottom">
                                      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 xs-responsive"><p class="medium bold margp text-danger">{{ $type[0] }} </p></div>
                                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 xs-responsive"><p class="medium text-right margp text-success" type="{{ $det[3] }}">{{ $det[3] }} </p></div>
                                    </div>

                                    <div class="col-lg-12 bg-white">
                                      <div class="col-lg-12 no-padding"><p class="medium no-margin">{{ '' }}</p></div>
                                      <div class="row no-padding">


                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 xs-responsive"><h4 class=" bold" amount="{{ 'llllll' }}">{{ 'N'.number_format(floatval($det[11]), 2) }}</h4></div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 xs-responsive"><p class="text-right-resp text-success"><button class="btn btn-customd disabled" >repeat</button> </p></div>
                                      </div>
                                      <div class="row no-padding">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 xs-responsive"><p class="medium no-margin">{{ $det[14] }} <br> {{ str_replace('Address', '', $det[13]) }}</p></div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 xs-responsive"><p class="text-right-resp medium text-success">
                                          {{ date('Y/m/d H:i:s', strtotime($det[8])) }}
                                        </p></div>
                                      </div>
                                    </div>
                                  </div>

                                  <?php
                                }else if(strpos( $det[0], 'Vending with Terminal') !== false && strpos( $det[3], ' ServiceChrgTx') === false){
                                  $type = explode('with', $det[0]);
                                  $amt = explode('of', $det[0]);
                                  $realAmt = explode('for', $amt[1]);

                                  $id = explode('(', $det[0]);
                                  $real = explode(')', $id[1]);
                                  ?>
                                  <div block="">
                                    <div class="col-lg-12 bdtop bdbottom">
                                      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 xs-responsive"><p class="medium bold margp text-danger">{{ $type[0] }} </p></div>
                                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 xs-responsive"><p class="medium text-right margp text-success">{{ $det[10] }} </p></div>
                                    </div>

                                    <div class="col-lg-12 bg-white">
                                      <div class="col-lg-12 no-padding"><p class="medium no-margin">{{ $real[0] }}</p></div>
                                      <div class="row no-padding">


                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 xs-responsive"><h4 class=" bold">{{ 'N'.number_format(floatval(trim($realAmt[0])), 2) }}</h4></div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 xs-responsive"><p class="text-right-resp text-success"><button class="btn btn-customd disabled" >repeat</button> </p></div>
                                      </div>
                                      <div class="row no-padding">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 xs-responsive"><p class="medium no-margin">{{ str_replace('Conlog', '', $det[7]) }} <br> {{ $det[8] }}</p></div>
                                          <!-- <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 xs-responsive"><p class="text-right-resp medium text-success">
                                            /* 'popoopopopopo' */
                                          </p></div> -->
                                        </div>
                                      </div>
                                    </div>



                                  <?php }else if(strpos( $det[6], 'ServiceChrgTx') === false){ ?>


                                    <div block="">
                                      <div class="col-lg-12 bdtop bdbottom">
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 xs-responsive"><p class="medium bold margp text-danger">{{ $det[6] }} </p></div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 xs-responsive"><p class="medium text-right margp text-success" type="{{ $det[0] }}">{{ $det[0] }} </p></div>
                                      </div>

                                      <div class="col-lg-12 bg-white">
                                        <div class="col-lg-12 no-padding"><p class="medium no-margin" service="{{ $det[2] }}">{{ $det[2] }}</p></div>
                                        <div class="row no-padding">


                                          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 xs-responsive"><h4 class=" bold" amount="{{ $det[1] }}">{{ $det[1] }}</h4></div>
                                          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 xs-responsive"><p class="text-right-resp text-success"><button class="btn btn-customd" >repeat</button> </p></div>
                                        </div>
                                        <div class="row no-padding">
                                          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 xs-responsive"><p>{{ $det[5] }} </p></div>
                                          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 xs-responsive"><p class="text-right-resp medium text-success">
                                            {{ $det[7] }}
                                          </p></div>
                                        </div>
                                      </div>
                                    </div>

                                  <?php } ?>

                                  <?php
                                endif;
                                if($i == 200) break;
                                ?>
                                @endforeach

                              </div>
                            </div>
                          </div>
                        </div>


                      </div>
                    </div>
                  </div>


                </div>
              </div>

            </div>


          </div>
        </div>

      </div>

    </div>
  </div>


</div>

</div>
</div>


</div>

</div>

  </div>

</section>

@stop
{{-- <script src="{{ URL::asset('js/parsley.min.js') }}"></script>
<script src="{{ URL::asset('js/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.notific8.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/payvice.validate.js') }}"></script> --}}

@push('scripts');
<script>
(function() {

  var quotes = $(".quotes");
  var quoteIndex = -1;

  function showNextQuote() {
    payMethod    ++quoteIndex;
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
  @endpush
