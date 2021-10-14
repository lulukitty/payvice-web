
<div class="panel-heading no-padding no-bg">

  <div class="row">
   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 xs-hidden"></div>
   <div class="col-lg-6 text-center col-md-6 col-sm-6 col-xs-12">
     <p class="fg-blue medium mt10">Wallet Ballance</p>
     <h1 class="bold big-font no-margin fg-green">&#8358;{{ $bal }}</h1>
     <h6 class="fg-blue">Wallet ID : {{ $_GET['id'] }}</h6>
     <div class="paddlr10">
      <button id="btnfundwalleta" class="btn-customb mb20 btn-block arrow-btn waves-effect waves-classic">
       FUND WALLET
     <span class="arrow"></span>
   </button>
 </div>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 xs-hidden"></div>



</div>


</div>


<div class="panel-footer no-bd">
 <div class="row">
  <div class="col-lg-12">
    <h4>Recent Transaction History</h4>
  </div>
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
                                    if($i == 20) break; 
                                    ?>
                                    @endforeach

                                  </div>

                                </div>