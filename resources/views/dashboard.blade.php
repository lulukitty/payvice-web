@extends('layouts.master')
@section('content')
<div id="wrapper" class="toggled " >
  <div role="navigation" class="wrap-body" id="sidebar-wrapper">
   @include('layouts.menu')

  <div class="p-20" id="page-content-wrapper">

<!-- 
    <a href="#" class="btn bg-paleb-opac  fixedtop ztop btn-default navbar-toggle block pull-left" id="menu-toggle"><span class="icon-bar"></span>
       <span class="icon-bar"></span>
       <span class="icon-bar"></span></a>
-->

<section class="no-bg"> 
@include('layouts.sub-menu')
<div class="row mt-100 no-margin select-billers">
<div class="col-lg-12">
<h4>Pay Bills</h4>  
<hr/>
</div>

<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 repadd-grid">
<a id="airtime_click" href="#">
<div class="card">
                 <div class="card-body">
                 <img class="logo-ic" src="{{ URL::asset('assets/img/buy-airtime.svg') }}" alt="">
                  <h5 class="mb-2">Buy Airtime </h5>
                </div>
              </div>
</a>
</div>
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 repadd-grid">
<a href="/tran/data">
<div class="card">
                 <div class="card-body">
                 <img class="logo-ic" src="{{ URL::asset('assets/img/buy-data.svg') }}" alt="">
                  <h5 class="mb-2">Buy Data </h5>
                </div>
              </div>
</a>
</div>
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 repadd-grid">
<a href="/tran/paybills?page=billoptionelectric">
<div class="card">
                 <div class="card-body">
                 <img class="logo-ic" src="{{ URL::asset('assets/img/electricity.svg') }}" alt="">
                  <h5 class="mb-2">Buy Electricity </h5>
                </div>
              </div>
</a>
</div>
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 repadd-grid">
<a href="/tran/paybills?page=billoptiontv">
<div class="card">
                 <div class="card-body">
                 <img class="logo-ic" src="{{ URL::asset('assets/img/pay-cabletv.svg') }}" alt="">
                  <h5 class="mb-2">Cable TV</h5>
                </div>
              </div>
</a>
</div>
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 repadd-grid">
<a href="/tran/paybills?page=billoptionint">
<div class="card">
                 <div class="card-body">
                 <img class="logo-ic" src="{{ URL::asset('assets/img/internet-bills.svg') }}" alt="">
                  <h5 class="mb-2">Internet Subscription </h5>
                </div>
              </div>
</a>
</div>
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 repadd-grid">
<a href="/tran/movie_tickets">
<div class="card">
                 <div class="card-body">
                 <img class="logo-ic" src="{{ URL::asset('assets/img/movie-tickets.svg') }}" alt="">
                  <h5 class="mb-2">Movie Tickets </h5>
                </div>
              </div>
</a>
</div>

{{-- <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 repadd-grid">
<a href="/tran/paybills#billoptiontoll">
<div class="card">
                 <div class="card-body">
                 <img class="logo-ic" src="{{ URL::asset('assets/img/toll-fee.svg') }}" alt="">
                  <h5 class="mb-2">Toll Fee</h5>
                </div>
              </div>
</a>
</div> --}}
</div> 


<!-- Airtime Top up -->
            <div id="airtime" class="row mt-100">
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">        
                    <div class="row no-margin">
                      <div class="col-lg-7 col-lg-offset-2 col-md-offset-2 col-md-8 col-sm-12 col-xs-12 padded-area">
                          <div class="tab-pane active" id="2b">
                          <form action="#" method="post" id="payAirtime" data-parsley-validate>
                        
                                <div class="airtime_stepone" id="topupForm">
                              <div class="mb-30">
                              <h4 class="inline mt-0">Buy Airtime</h4>  
                                <span class="pull-right">
                                <img id="telco_imageb" class="rounded-ic" src="{{ URL::asset('assets/img/null_img.png') }}" />
                                </span> 
                              </div>
                                
                                  <div class=" form-group">
                                        <i class="ion-android-phone-portrait fstylec"></i>
                                      <select id="telco_listb"  placeholder="select mobile network" class="form-control" required name="network">
                                        <option value="" img="{{ URL::asset('assets/img/null_img.png') }}">select mobile network</option>
                                        <option value="MTN" img="{{ URL::asset('assets/img/mtn_img.png') }}">MTN</option>
                                        <option value="GLOVTU" img="{{ URL::asset('assets/img/glo_img.png') }}">GLO</option>
                                        <option value="ETST" img="{{ URL::asset('assets/img/etisalat_img.png') }}">ETISALAT</option>
                                        <option value="AIRT" img="{{ URL::asset('assets/img/airtel_img.png') }}">AIRTEL</option>
                                      </select>                                                                   
                                 </div>
                                 <div class=" form-group">     
                                      <i class="ion-android-call fstylec"></i>
                                    <input placeholder="ENTER PHONE NUMBER" class="form-control" type="text" required min="11" name="phone">               
                                </div>
                                <div class=" form-group">  
                                      <span class="fstylec">&#8358;</span>
                                    <input class="form-control" type="text" id="newsletter-email" name="amount" placeholder="ENTER AMOUNT" required>
                                </div>
                                <br/>
                                <div class="form-group no-margin">
                                  <button type="submit" id="swapBtnForm" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                                    PROCEED
                                  <span class="arrow"></span>
                                </button>
                              </div>

                            </div>

                            <div class="airtime_steptwo" id="vtuSwap">
                            <a id="backairtimestepone" class="btn abs-left no-bd btn-default waves-effect waves-light"> <i class="fa m-0 fa-arrow-left"></i></a>
                              <div class="text-center mb-50">
                                <div class="authimg">
                                  <img style="margin: 20px auto;" src="{{ URL::asset('assets/img/password.svg') }}">
                                </div>
                                <h4>Your 4 Digit PIN</h4>
                                <P class="medium">This is your personal digit PIN needed to complete this transaction</P>
                              </div>
                              <div class="">
                                <div class=" form-group">
                                  <input type="password" style="margin:0px auto" class="pincode-input5"  name="pin" >
                                </div>
                                <br>
                                <div class="form-group no-margin">
                                  <button id="pinProceed" type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                                    <span class="payBtn">PROCEED</span>
                                  <span class="arrow"></span>
                                </button>

                              </div>
                            </div>
                          </div>
                          <div class="airtime_stepthree" id="payMethod">
                          <a id="backairtimesteptwo" class="btn abs-left no-bd btn-default waves-effect waves-light"> <i class="fa m-0 fa-arrow-left"></i></a>
                          <h4 class="mb-20">Payment Methods</h4>
                           <div class="text-center">
                           
                   <div class="row text-center">
                     <div class="col-md-12 col-sm-12 p-20 text-center payProcess">

                     </div>
                   </div>
                 </div>
                 <div class="panel-body no-padding text-center">
                  <ul class="list-group">

                    <li class="list-group-item">
                      <label class="radio labelchk no-margin no-bg"><input type="radio" class="rel-radioright" name="payMethod"><span class="imgchkk"><img src="{{ URL::asset('assets/img/payvice_logob.png') }}" /></span>   USE PAYVICE WALLET</label>
                    </li>
                    <li class="list-group-item">
                      <label class="radio labelchk no-margin no-bg"><input type="radio" class="rel-radioright" name="payMethod" disabled ><span class="imgchkk"><img src="{{ URL::asset('assets/img/credit_card_link.png') }}" /></span>   USE LINKED CARD(S)</label>
                    </li>
                    <li class="list-group-item">
                      <label class="radio labelchk no-margin no-bg"><input type="radio" class="rel-radioright" name="payMethod" disabled ><span class="imgchkk"><img src="{{ URL::asset('assets/img/debit_credit_card.png') }}" /></span>   DEBIT/CREDIT CARD</label>
                    </li>

                  </ul>
                </div>
                <div class="no-bd">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <button id="showmenu" type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                    <span class="payBtnLst"> PAY</span>
                  <span class="arrow"></span>
                </button>
              </div>
            </div>
          </form>
        </div>

    <div style="display:none" class="tab-pane" id="1b">
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
          
        </div>

        @include('layouts.side-adv')
</section>
      <div class="row">
        <div class="col-lg-12 no-padding">
     
              <section class="no-bg hidden">
                <ul class="nav nav-tabs no-bd presentationtab" role="tablist">
                  <li role="presentation" class="active col-lg-3 col-md-6 col-sm-6 col-xs-12 no-padding"><a href="#dashboard" aria-controls="home" role="tab" data-toggle="tab"> <i class="ion-ios-browsers-outline fstylec"></i>Dashboard</a></li>
                  <li class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-padding" role="presentation"><a href="#airtime" aria-controls="profile" role="tab" data-toggle="tab"><i class="ion-ipad fstylec"></i>Quick Airtime Top-up</a></li>
                  <li class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-padding" role="presentation"><a href="{{url('/tran/paybills')}}" ><i class="ion-ios-paper-outline fstylec"></i>Pay Utility Bills</a></li>
                  <li class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-padding" role="presentation"><a href="#wallet" aria-controls="settings" role="tab" data-toggle="tab"><i class="ion-folder fstylec"></i>My Wallet</a></li>
                </ul>

                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="dashboard">

                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="panel no-bg no-bd panel-default margalt">
                          <div class="panel-body no-padding no-bg">
                            <div class="row">
                             <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                              <div class="panel panel-default center-panel loadSearch">
                                <div class="panel-heading no-padding no-bg">

                                  <div class="row">
                                   <div class="col-lg-12 text-center col-md-12 col-sm-12 col-xs-12">
                                    

                                     <div class="paddlr10">
                                      <div class = "col-md-6 col-sm-12">
                                       <button id="btnfundwalleta" class="btn-customb mb20 btn-block arrow-btn waves-effect waves-classic">
                                        FUND WALLET
                                      <span class="arrow"></span>
                                    </button>
                                  </div>
                                  <div class = "col-md-6 col-sm-12">
                                   <a href = "{{url('/transfer-commission')}}" class="btn-customb mb20 btn-block arrow-btn waves-effect waves-classic">
                                    TRANSFER COMMISSION
                                  <span class="arrow"></span>
                                </a>
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
          
      <div role="tabpanel" class="tab-pane" id="paybills">
        <div class="row">

          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div id="billoptiontv" class="panel panel-default margalt">
             <div class="panel-heading fstyleb"><i class="ion-monitor fstylec"></i>Cable TV</div>
             <div class="panel-body">

              <div class="utility-slide">
                <div id="showbill"><a  href="#"><img src="{{ URL::asset('assets/img/util_gotv.png') }}" /></a></div>
                <div><a id="showbill" href="#"><img src="{{ URL::asset('assets/img/util_dstv.png') }}" /></a></div>
                <div><a id="showbill" href="#"><img src="{{ URL::asset('assets/img/util_startime.png') }}" /></a></div>
              </div>
            </div>


            <!-- billstepone -->
            <div class="row">
              <div class="col-lg-2 col-md-2 col-sm-2 xs-hidden col-xs-12"></div>
              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div id="billstepone" class="panel no-bd shadow panel-default marg10">
                  <div class="panel-body">
                   <div class=" form-group">
                    <div class="input-group">
                      <div class="input-group-addon no-padding no-bg no-bd">

                        <i class="ion-ios-paper-outline fstylec"></i>

                      </div>
                      <input placeholder="Cable TV Selected" class="form-control" type="number" required min="11" name="phone">
                      <div style="width:30px" class="input-group-addon no-padding no-bg no-bd">
                       <img id="telco_imageb" src="http://127.0.0.1:8000/assets/img/glo_img.png">
                     </div>



                   </div>
                 </div>
                 <div class=" form-group">
                  <div class="input-group">
                    <div class="input-group-addon no-padding no-bg no-bd">
                      <i class="ion-person fstylec"></i>
                    </div>
                    <input placeholder="SMART CARD NUMBER" class="form-control" type="number" required min="11" name="phone">
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
                <div class=" form-group">
                  <div class="input-group">
                    <div class="input-group-addon no-padding no-bg no-bd">
                      <i class="ion-android-time fstylec"></i>
                    </div>
                    <input placeholder="How many months?" class="form-control" type="number" required min="11" name="phone">
                  </div>
                </div>
                <br/>
                <div class="form-group">

                  <button type="submit" id="swapBillAuthForm" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                    PROCEED
                  <span class="arrow"></span>
                </button>
              </div>
            </div>

          </div>

        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 xs-hidden col-xs-12"></div>

      </div>

      <!-- Authenticate bill-payment -->
      <div class="row">
       <div class="col-lg-2 col-md-2 col-sm-2 xs-hidden col-xs-12"></div>
       <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
         <div id="billsteptwo" class="panel panel-default marg10 no-bd shadow">

           <div class="panel-body no-padding">
             <form action="#" method="post" id="goPin" data-parsley-validate="" novalidate>
              <div id="topupForm" style="display: none;">

                <br>
                <div class=" form-group">
                  <div class="input-group">
                    <div class="input-group-addon no-padding no-bg no-bd">

                      <i class="ion-android-phone-portrait fstylec"></i>

                    </div>
                    <select id="telco_listb" placeholder="select mobile network" class="form-control parsley-success" required="" name="network" data-parsley-id="5">

                      <option value="" img="http://127.0.0.1:8000/assets/img/null_img.png">select mobile network</option>
                      <option value="MTN" img="http://127.0.0.1:8000/assets/img/mtn_img.png">MTN</option>
                      <option value="GLOVTU" img="http://127.0.0.1:8000/assets/img/glo_img.png">GLO</option>
                      <option value="ETST" img="http://127.0.0.1:8000/assets/img/etisalat_img.png">ETISALAT</option>
                      <option value="AIRT" img="http://127.0.0.1:8000/assets/img/airtel_img.png">AIRTEL</option>
                    </select>

                    <div style="width:30px" class="input-group-addon no-padding no-bg no-bd">
                     <img id="telco_imageb" src="http://127.0.0.1:8000/assets/img/etisalat_img.png">
                   </div>

                 </div>
               </div>



               <div class=" form-group">
                <div class="input-group">
                  <div class="input-group-addon no-padding no-bg no-bd">
                    <i class="ion-android-call fstylec"></i>
                  </div>
                  <input placeholder="ENTER PHONE NUMBER" class="form-control parsley-success" type="number" required min="11" name="phone" data-parsley-id="7">
                </div>
              </div>

              <div class=" form-group">
                <div class="input-group">
                  <div class="input-group-addon no-padding no-bg no-bd">
                    <span class="fstylec">₦</span>
                  </div>
                  <input class="form-control parsley-success" type="number" id="newsletter-email" name="amount" placeholder="ENTER AMOUNT" required data-parsley-id="9">

                </div>
              </div>
              <br>

              <div class="form-group">

                <button id="swapBtnForm" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                  PROCEED
                <span class="arrow"></span>
              </button>
            </div>

          </div>

          <div id="vtuSwap" class="panel panel-default no-margin">

            <div class="panel-body text-center">
              <div class="authimg">
                <img src="{{ URL::asset('assets/img/screen.png') }}">
              </div>


              <h4>Your 4 Digit PIN</h4>
              <P class="medium">This is your personal digit PIN needed to complete this transaction</P>
            </div>
            <div class="panel-footer no-bd">
              <div class=" form-group">

                <input type="password" style="margin:0px auto" class="pincode-input5"  name="pin" >


              </div>

              <br>
              <div class="form-group ">
                <button id="pinProceed" type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                  <span class="payBtn">PROCEED</span>
                <span class="arrow"></span>
              </button>
            </div>
          </div>
        </div>
        <div id="payMethod" class="panel panel-default" style="display: none;">

         <div class="panel-heading text-center">
           <div class="row">
            <!--div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 xs-hidden"></div-->
            <div class="col-lg-12 text-center col-md-12 col-sm-12 col-xs-12">
              <p class="fg-blue medium mt10">Wallet Balance</p>
              <h1 class="bold big-font no-margin fg-green">&#8358;{{ $balance }}</h1>
              <h6 class="fg-blue">Commission Balance: <b> &#8358;{{ $commissionBalance }} </b></h6>
              <h6 class="fg-blue">Wallet ID : {{ Session::get('curAcc') }}</h6>

              <div class="paddlr10">
               <div class = "col-md-6 col-sm-12">
                <button id="btnfundwalleta" class="btn-customb mb20 btn-block arrow-btn waves-effect waves-classic">
                 FUND WALLET
               <span class="arrow"></span>
             </button>
           </div>
           <div class = "col-md-6 col-sm-12">
            <a href = "{{url('/transfer-commission')}}" class="btn-customb mb20 btn-block arrow-btn waves-effect waves-classic">
             TRANSFER COMMISSION
           <span class="arrow"></span>
         </a>
       </div>

     </div>
   </div>
   <!--div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 xs-hidden"></div-->

 </div>
</div>
<div class="panel-body text-center">
  <ul class="list-group shadow">

    <li class="list-group-item">
      <label class="radio labelchk no-margin no-bg"><input type="radio" class="rel-radioright" name="payMethod" data-parsley-multiple="payMethod" data-parsley-id="24"><span class="imgchkk"><img src="http://127.0.0.1:8000/assets/img/payvice_logob.png"></span>   USE PAYVICE WALLET</label>
    </li>
    <li class="list-group-item">
      <label class="radio labelchk no-margin no-bg"><input type="radio" class="rel-radioright" name="payMethod" disabled="" data-parsley-multiple="payMethod"><span class="imgchkk"><img src="http://127.0.0.1:8000/assets/img/credit_card_link.png"></span>   USE LINKED CARD(S)</label>
    </li>
    <li class="list-group-item">
      <label class="radio labelchk no-margin no-bg"><input type="radio" class="rel-radioright" name="payMethod" disabled="" data-parsley-multiple="payMethod"><span class="imgchkk"><img src="http://127.0.0.1:8000/assets/img/debit_credit_card.png"></span>   DEBIT/CREDIT CARD</label>
    </li>

  </ul>
</div>
<div class="panel-footer no-bd">
  <input type="hidden" name="_token" value="e7KqRV7c7s9w5w7qOdgdJwTuCcS28CUFZKZoMaOQ">
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
<div class="col-lg-2 col-md-2 col-sm-2 xs-hidden col-xs-12"></div>
</div>

</div>


<div id="billoptionint" class="panel panel-default margalt">
  <div class="panel-heading fstyleb"><i class="ion-android-wifi fstylec"></i>Internet Services</div>
  <div class="panel-body">
    <div class="utility-slide">
      <div><img src="{{ URL::asset('assets/img/util_smile.png') }}" /></div>
    </div>
  </div>
</div>

<div id="billoptionutil" class="panel panel-default margalt">
  <div class="panel-heading fstyleb"><i class="ion-android-bulb fstylec"></i>Utilities</div>
  <div class="panel-body">
    <div class="utility-slide">
      <div><img src="{{ URL::asset('assets/img/util_ikedc.png') }}" /></div>
      <div><img src="{{ URL::asset('assets/img/util_ekedc.png') }}" /></div>
      <div><img src="{{ URL::asset('assets/img/util_lcc.png') }}" /></div>
    </div>
  </div>
</div>

<div id="billoptionother" class="panel panel-default margalt">
  <div class="panel-heading fstyleb"><i class="ion-android-apps fstylec"></i>Others</div>
  <div class="panel-body">
    <div class="utility-slide">
      <div><img src="{{ URL::asset('assets/img/util_waec.png') }}" /></div>
    </div>
  </div>
</div>

</div>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
  <div role="tabpanel" class="tab-pane" >
    <div class="row">

    </div>
  </div>

  <div class="col-lg-5  col-md-5 col-sm-5 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading"><h4 class="no-margin">Recent Recharge</h4></div>

   
    </div>
  </div>

<!-- Data Top up -->


</div>
</div>
</div>
</div>
@stop