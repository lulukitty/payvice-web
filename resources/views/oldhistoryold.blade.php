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
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <a href="#" class="btn bg-paleb-opac fixedtop ztop btn-default navbar-toggle block pull-left" id="menu-toggle"><span class="icon-bar"></span>
     <span class="icon-bar"></span>
     <span class="icon-bar"></span></a>
     <div class="">
      <div class="row">


        <div class="col-lg-12">


         <div class="particle-bg" id="particles"><canvas class="particles-js-canvas-el" width="1349" height="913" style="width: 100%; height: 100%;"></canvas></div>       


         <div class="paddlr10">
          <div class="row row-offcanvas row-offcanvas-left">



            <!-- main area -->
            <div class="col-xs-12 col-lg-12 min-height col-md-12 col-sm-12">




              <section class="paddsection-resp no-bg">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs no-bd presentationtab" role="tablist">
                  <li role="presentation" class="active col-lg-3 col-md-6 col-sm-6 col-xs-12 no-padding"><a href="#dashboard" aria-controls="home" role="tab" data-toggle="tab"> <i class="ion-ios-browsers-outline fstylec"></i>Dashboard</a></li>

                  <li class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-padding" role="presentation"><a href="#airtime" aria-controls="profile" role="tab" data-toggle="tab"><i class="ion-ipad fstylec"></i>Quick Airtime Top-up</a></li>
                  <li class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-padding" role="presentation"><a href="{{url('/tran/paybills')}}" ><i class="ion-ios-paper-outline fstylec"></i>Pay Utility Bills</a></li>
                  <li class="col-lg-3 col-md-6 col-sm-6 col-xs-12 no-padding" role="presentation"><a href="#wallet" aria-controls="settings" role="tab" data-toggle="tab"><i class="ion-folder fstylec"></i>My Wallet</a></li>
                </ul>

                <!-- Tab panes -->
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

                      <div class="panel-footer no-bd">
                       <div class="row">
                        <div class="col-lg-12">
                          <h4>Recent Transaction History </h4>
                        </div>

                        <?php 
                        $i = 0; 

                              /*echo "<pre>", print_r($hist), "</pre>";
                              exit();*/
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
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">


                         <div class="panel big_shadow no-bd text-center panel-default">

                          <div class="panel-body"><img class="w50" src="{{ URL::asset('assets/img/refer_img.png') }}" />

                          </div>
                          <div class="panel-footer">
                            <h5 class="no-margin bold">Refer & Earn</h5>
                          </div>
                        </div>

                        <div class="panel big_shadow no-bd text-center panel-default">

                          <div class="panel-body"><img class="w50" src="{{ URL::asset('assets/img/offer_img.png') }}" />
                          </div>
                          <div class="panel-footer">
                            <h5 class="no-margin bold"> Promo Offers</h5>
                          </div>
                        </div>

                        <input type="hidden" name="wallID" value="{{ Session::get('curAcc') }}">


                        <div class="panel big_shadow no-bd text-center panel-default agentLoader">

                          <div class="panel-body eachAgent">
                            <!-- Load sub-agents here -->
                          </div>
                          <div class="panel-footer">
                            <h5 class="no-margin bold"> Sub-agents List</h5>
                          </div>
                        </div>


                      </div>


                    </div>

                  </div>

                </div>

              </div>






            </div>

          </div>
          <div role="tabpanel" class="tab-pane" id="airtime">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel no-bg no-bd panel-default margalt">
                  <div class="panel-body no-padding no-bg">
                    <div class="row">
                      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">

                        <div class="text-center row" data-toggle="buttons">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> <label href="#2b" data-toggle="tab" style="display:block" class="btn  btn-custombd btn-circle active"> <input type="radio" class="rel-radio" name="q1" value="1" checked >Airtime VTU</label></div>
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
                                        <option value="ETST" img="{{ URL::asset('assets/img/etisalat_img.png') }}">ETISALAT</option>
                                        <option value="AIRT" img="{{ URL::asset('assets/img/airtel_img.png') }}">AIRTEL</option>
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
                   <div class="row text-center">
                     <div class="col-md-12 col-sm-12 text-center payProcess">
                       
                     </div>
                   </div>
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

                              /*echo "<pre>", print_r($hist), "</pre>";
                              exit();*/
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
                                if($i == 10) break; 
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

                <input type="text" style="margin:0px auto" class="pincode-input5"  name="pin" >


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
      <label class="radio labelchk no-margin no-bg"><input type="radio" class="rel-radioright" name="payMethod" data-parsley-multiple="payMethod" data-parsley-id="24"><spam class="imgchkk"><img src="http://127.0.0.1:8000/assets/img/payvice_logob.png"></spam>   USE PAYVICE WALLET</label>
    </li>
    <li class="list-group-item">
      <label class="radio labelchk no-margin no-bg"><input type="radio" class="rel-radioright" name="payMethod" disabled="" data-parsley-multiple="payMethod"><spam class="imgchkk"><img src="http://127.0.0.1:8000/assets/img/credit_card_link.png"></spam>   USE LINKED CARD(S)</label>
    </li>
    <li class="list-group-item">
      <label class="radio labelchk no-margin no-bg"><input type="radio" class="rel-radioright" name="payMethod" disabled="" data-parsley-multiple="payMethod"><spam class="imgchkk"><img src="http://127.0.0.1:8000/assets/img/debit_credit_card.png"></spam>   DEBIT/CREDIT CARD</label>
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

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default margalt">
          <div class="panel-heading">Recent Transaction</div>
          <div class="panel-body">
            <div class="row">
              <?php 
              $i = 0; 

                              /*echo "<pre>", print_r($hist), "</pre>";
                              exit();*/
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

              <div role="tabpanel" class="tab-pane" id="wallet">

                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel no-bg no-bd panel-default margalt">
                      <div class="panel-body no-padding no-bg">

                        <div class="row">
                         <div class="col-lg-7  col-md-7 col-sm-7 col-xs-12">
                          <div class="panel panel-default ">
                            <div class="panel-heading text-center">
                              <div class="row">
                               <!--div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 xs-hidden"></div-->
                               <div class="col-lg-12 text-center col-md-12 col-sm-12 col-xs-12">
                                 <p class="fg-blue medium mt10">Wallet Balance</p>
                                 <h1 class="bold big-font no-margin fg-green">&#8358;{{ $balance }}</h1>
                                 <h6 class="fg-blue">Commission Balanc
                                  e: <b> &#8358;{{ $commissionBalance }} </b></h6>
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
                  <div class=" panel-body">
                   <div class="row">
                     <div id="hdwallet">
                      <div class="col-lg-6 addbafter col-md-6 text-center col-sm-6 col-xs-6 xs-responsive">
                        <a id="wallettrans" class="hvr-pop" href="#">          <img src="{{ URL::asset('assets/img/wallet_transfer.png') }}" />    </a>     


                        <h5>Wallet-to-Wallet-Transfer </h5>
                      </div>
                      <div class="col-lg-6 col-md-6 text-center col-sm-6 col-xs-6 xs-responsive">

                        <a class="hvr-pop" id="linkedcard" href="#"> <img src="{{ URL::asset('assets/img/card-link.png') }}" />    </a> 

                        <h5>Linked Cards</h5>
                      </div>
                    </div>


                    <div id="wallettransferstepone" class="panel no-bd  panel-default">
                      <div class="panel-heading no-bg text-center">
                        <div style="width:60px" class="input-group-addon absright no-padding no-bg no-bd">
                          <a id="closewallet" href="#"><i class="ion-close-circled anchor-danger btn f20"></i></a>  
                        </div>
                        <h3 class="fg-dark">Wallet Transfer</h3>
                        <p class="fg-dark">Transfer fund from your wallet to another wallet</p>



                      </div>
                      <div class="panel-body allmargnotopb">

                       <div class=" form-group">
                        <div class="input-group">
                          <div class="input-group-addon no-padding no-bg no-bd">
                            <i class="ion-person fstylec"></i>
                          </div>
                          <input placeholder="Recipient wallet id" class="form-control" type="number" required min="11" name="phone">
                          <div style="width:30px" class="input-group-addon no-padding no-bg no-bd">
                            <i class="ion-information-circled"></i>   
                          </div>

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

                        <button type="submit" id="swapWalletAuthForm" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                          PROCEED
                        <span class="arrow"></span>
                      </button>      
                    </div>
                  </div>

                </div>


                <div id="wallettransfersteptwo" class="panel no-bd  panel-default">

                  <div class="panel-body no-padding shadow allmargnotopd">

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

                        <input type="text" style="margin:0px auto" class="pincode-input5"  name="pin" >


                      </div> 

                      <br>
                      <div class="form-group ">
                        <button id="pinProceed" type="submit" class="btn-custom btn-block arrow-btn waves-effect waves-classic">
                          <span class="payBtn">PROCEED</span>
                        <span class="arrow"></span>
                      </button>                            




                    </div>   

                  </div>


                </div>




              </div>

            </div>
            <div class="row">
              <div class="col-lg-2 col-md-2 col-sm-1 col-xs-12"></div>
              <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">

                <div id="walletfundstepone" class="panel shadow no-bd  panel-default">
                  <div class="panel-heading no-bg text-center">
                    <div style="width:60px" class="input-group-addon absright no-padding no-bg no-bd">
                      <a id="closefundwallet" href="#"><i class="ion-close-circled anchor-danger btn f20"></i></a>  
                    </div> 
                    <h3 class="fg-dark">Enter Amount</h3>
                    <p class="fg-dark">Please enter the transaction amount</p>

                  </div>
                  <div class="panel-body">

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

                      <button type="submit" id="swapWalletAuthForm" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                        PROCEED
                      <span class="arrow"></span>
                    </button>      
                  </div>
                </div>

              </div>

            </div>
            <div class="col-lg-2 col-md-2 col-sm-1 col-xs-12"></div>
          </div>   





          <div id="linkcardstepone" class="panel no-bd  panel-default">

            <div class="panel panel-heading no-bd no-shadow no-bg">
              <div style="width:60px" class="input-group-addon absright no-padding no-bg no-bd">
                <a id="closelinkcard" href="#"><i class="ion-close-circled anchor-danger btn f20"></i></a>  
              </div> 
            </div>  

            <div class="panel-body allmargnotopb">


             <!-- Creit card -->

             <div class="container">
               <div class="row">  



                <a class="hvr-push absadd" href="#"><i class="ion-plus-circled  fa-4x"></i></a>
              </div></div>









              <br/>

            </div>

          </div>  
        </div>







      </div>

    </div>
  </div>

  <div class="col-lg-5  col-md-5 col-sm-5 col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading"><h4 class="no-margin">Recent Recharge</h4></div>



      <div class="panel-footer no-bd">
       <div class="row">
        <div class="col-lg-12">
          <h4>Recent Transaction History </h4>
        </div>

        <?php 
        $i = 0; 

                              /*echo "<pre>", print_r($hist), "</pre>";
                              exit();*/
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
                                if($i == 10) break; 
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














        </section>

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
@stop