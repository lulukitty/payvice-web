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
<div id="paybills">
                    <div class="row">

                      <div class="col-lg-12 col-md-12 col-sm-12 mb-50 col-xs-12">
                        <div class="mb-30">
                        <a class="inline" href="/tran"><i class="ion-home block fstyleic"></i></a>
                        <h4 class="right">Fund Account</h4>
                        <hr class="no-margin f-width"/>
                        </div>
                     
                         <div class="row mb-30">
                         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                         <div class="panel panel-default"> 
                         <div class="panel-body">
                         <img src="{{ URL::asset('assets/img/exchange.svg') }}" />
                         <p class="medium no-margin bold text-center">Card</p>
                         </div>
                         </div>
                        
                         </div>
                         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                         <div class="panel panel-default"> 
                         <div class="panel-body">
                         <img src="{{ URL::asset('assets/img/bank.svg') }}" />
                         <p class="medium no-margin bold text-center">Bank</p>
                         </div>
                         </div>
                         </div>
                         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                         <div class="panel panel-default"> 
                         <div class="panel-body">
                         <img src="{{ URL::asset('assets/img/wallet-transfer.svg') }}" />
                         <p class="medium no-margin bold text-center">Wallet Transfer</p>
                         </div>
                         </div>
                         </div>
                         </div>
                       <div class="row">
                       <div class="mb-30">
                        
                        <h4>Recent Transaction History</h4>
                        <hr class="no-margin f-width"/>
                        </div>
                        <div class="list-group list-group-alt">
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
                                  
                                        <a href="#" class="list-group-item flex-item ">
                                          <div class="row no-margin">
                                          <p class="medium bold margp text-danger">{{ $type[0] }} </p>
                                        <p class="medium text-right margp text-success" type="{{ $det[3] }}">{{ $det[3] }} </p>
                                        <p class="medium no-margin">{{ '' }}</p>
                                          </div>
                                          <div class="row no-margin">
                                          <h4 class=" bold" amount="{{ 'llllll' }}">{{ 'N'.number_format(floatval($det[11]), 2) }}</h4>
                                        <p class="medium no-margin">{{ $det[14] }} <br> {{ str_replace('Address', '', $det[13]) }}</p>
                                        <p class="text-right-resp medium text-success">
                                          {{ date('Y/m/d H:i:s', strtotime($det[8])) }}
                                        </p>    
                                          </div>
                                        
                                      </a>
                                                                          <?php
                                }else if(strpos( $det[0], 'Vending with Terminal') !== false && strpos( $det[3], ' ServiceChrgTx') === false){
                                  $type = explode('with', $det[0]);
                                  $amt = explode('of', $det[0]);
                                  $realAmt = explode('for', $amt[1]);

                                  $id = explode('(', $det[0]);
                                  $real = explode(')', $id[1]);
                                  ?>
                                   
                                        <a href="#" class="list-group-item flex-item ">
                                        <div class="row no-margin">
                                        <p class="small text-success">{{ $det[10] }} </p>
                                        <h4 class="text-success">{{ $real[0] }}</h4>
                                        <p class="small no-margin">{{ '' }}</p>
                                        </div>
                                        <div class="row no-margin">
                                        <p class="small">{{ str_replace('Conlog', '', $det[7]) }} <br> {{ $det[8] }}</p>
                                        <h4 class="bold">{{ 'N'.number_format(floatval(trim($realAmt[0])), 2) }}</h4>
                                        <p class="small text-success">
                                          {{ date('Y/m/d H:i:s', strtotime($det[8])) }}
                                        </p>  
                                        </div>  
                                      </a>
                                                                                
                                   
                                   
                                  <?php }else if(strpos( $det[6], 'ServiceChrgTx') === false){ ?>

                                        <a href="#" class="list-group-item flex-item ">
                                          <div class="row no-margin">
                                          <p class="small bold text-danger">{{ $det[6] }} </p>
                                        <h4 class="text-success" type="{{ $det[0] }}">{{ $det[0] }} </h4>
                                        <p class="small no-margin" service="{{ $det[2] }}">{{ $det[2] }}</p>
                                          </div>
                                          <div class="row no-margin">
                                          <p class="small">ref: {{ $det[5] }} </p>
                                          <h4 class=" bold" amount="{{ $det[1] }}">{{ $det[1] }}</h4>
                                        <p class="small text-success">
                                            {{ $det[7] }}
                                          </p>  
                                          </div>
                                      </a>
                                        
                                  <?php } ?>
                                 
                                  <?php
                                endif;
                                if($i == 7) break;
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
                    @include('layouts.side-adv')
                  </div>

</div>
</div>

</div>

</section>
</div>

</div>
@stop
@push('scripts')

<!--Hide Show Utility Bill-->
<script>

  $(document).ready(function() {
    // Cable TV
    $('#billstepone_cable').hide();
    $('#billsteptwo_cable').hide();
    $('#payMethod_cable').hide();

    // Internet Services
    $('#billstepone_internet').hide();
    $('#billsteptwo_internet').hide();
    $('#payMethod_internet').hide();

    // Utilities 
    $('#billstepone_utility').hide();
    $('#billsteptwo_utility').hide();
    $('#payMethod_internet').hide();

    // Others
    $('#billstepone_others').hide();
    $('#billsteptwo_others').hide();
    $('#payMethod_others').hide();

    // Utilities
    $('.showUtilities').click(function() {
      var img = $(this).attr('data-img');
      var servImg ="";
      var servType = "";

      switch(img){
        case 'ikedc':
        servImg = 'util_ikedc.png';
        servType = "IKEJA ELECTRIC";
        $("#utilRoute").html("<input type=\"hidden\" id=\"utilType\" value=\""+servType+"\" />");
        break;
        case 'ekedc':
        servImg = 'util_ekedc.png';
        servType = "EKO ELECTRIC";
        $("#utilRoute").html("<input type=\"hidden\" id=\"utilType\" value=\""+servType+"\" />");
        break;
        case 'lcc':
        servImg = 'util_lcc.png';
        servType = "LCC";
        $("#utilRoute").html("<input type=\"hidden\" id=\"utilType\" value=\""+servType+"\" />");
        break;
        case 'ibedc':
        servImg = 'util_ibedc.png';
        servType = "IBADAN ELECTRIC";
        $("#utilRoute").html("<input type=\"hidden\" id=\"utilType\" value=\""+servType+"\" />");
        break;
        case 'eedc':
        servImg = 'util_eedc.jpg';
        servType = "ENUGU ELECTRIC";
        $("#utilRoute").html("<input type=\"hidden\" id=\"utilType\" value=\""+servType+"\" />");
        break;
        case 'phed':
        servImg = 'PHED.png';
        servType = "PORTHARCOURT ELECTRIC";
        $("#utilRoute").html("<input type=\"hidden\" id=\"utilType\" value=\""+servType+"\" />");
        break;
      }

      $("#serviceIcon_utility").html("<img id=\"telco_imageb\" style='height: 30px!important; width: 50px!important; margin-left: 3px;' src=\"{{ URL::asset('assets/img') }}/"+servImg+"\">");
      $('input[name="utility_unit"]').attr({'readonly': true, 'value': servType}).val(servType).removeAttr('placeholder');
      // Show slides
      $('#billstepone_utility').fadeIn("slow");
      // Hide Others
      $('#billstepone_internet').hide();
      $('#billstepone_cable').hide();
      return false;
    });

    $('.showCableBill').click(function() {
      var img = $(this).attr('data-img');
      var servImg ="";
      var servType = "";

      switch(img){
        case 'gotv':
        servImg = 'util_gotv.png';
        servType = "GOTV";
        break;
        case 'dstv':
        servImg = 'util_dstv.png';
        servType = "DSTV";
        break;
        case 'startime':
        servImg = 'util_startime.png';
        servType = "STARTIMES";
        break;

      }
      $("#serviceIcon_cable").html("<img id=\"telco_imageb\" src=\"{{ URL::asset('assets/img') }}/"+servImg+"\">");
      $('input[name="cable_unit"]').attr({'readonly': true, 'value': servType}).val(servType).removeAttr('placeholder');
      // Show slides
      $('#billstepone_cable').fadeIn("slide");
      // Hide Others
      $('#billstepone_internet').hide("slide");
      $('#billstepone_utility').hide("slide");

      return false;
    });

    // Internet Section
    $('.showInternetBill').click(function() {
      var img = $(this).attr('data-img');
      var servImg ="";
      var servType = "";

      switch(img){
        case 'smile':
        servImg = 'util_smile.png';
        $('input[name=card]').attr('placeholder', ' Select and Enter Smile Account Number/Phone');
        servType = 'SMILE';
        $('input[name=biller]').attr('value', 'smileBiller');
        $('.service-options-smile').show();
        break;
      }

      $("#serviceIcon_internet").html("<img id=\"telco_imageb\" src=\"{{ URL::asset('assets/img') }}/"+servImg+"\">");
      $('input[name="cTv_internet"]').attr({'readonly': true, 'value': servType}).val(servType).removeAttr('placeholder');
      // Show slides
      $('#billstepone_internet').fadeIn("slow");
      // Hide Other Slides
      $('#billstepone_cable').hide();
      $('#billstepone_utility').hide();
      
      return false;
    });
  });

  // Submit CableBill Form 
  $("#cableBill").submit(function (e) {
        e.preventDefault();
        var spintext = 'Validating IUC Number';
        submit_form('cableBill', "{{ route('validateIUC') }}", spintext, 'cableResponse', 'subPlan_cable', false);
  });

  // billoptionutil
  $("#utilOption").submit(function (e) {
        e.preventDefault();
        var spintext = 'Please Wait... Validating Meter Number';
        var utilType = document.getElementById("utilType").value;
       
        if(utilType == "EKO ELECTRIC"){
          submit_form('utilOption', "{{ route('meterEkoLookup') }}", spintext, 'utilityResponse', 'subPlan_utility', false);
        } else if(utilType == "IKEJA ELECTRIC"){
          submit_form('utilOption', "{{ route('meterIELookup') }}", spintext, 'utilityResponse', 'subPlan_utility', false);
        } else if (utilType == "IBADAN ELECTRIC"){
          submit_form('utilOption', "{{ route('meterIBELookup') }}", spintext, 'utilityResponse', 'subPlan_utility', false);
        } else if (utilType == "ENUGU ELECTRIC"){
          submit_form('utilOption', "{{ route('meterEELookup') }}", spintext, 'utilityResponse', 'subPlan_utility', false);
        } else if (utilType == "PORTHARCOURT ELECTRIC"){
          submit_form('utilOption', "{{ route('meterPHELookup') }}", spintext, 'utilityResponse', 'subPlan_utility', false);
        }

  });

  $(document).on('submit', 'form#planSelectForm', function(event) {
    event.preventDefault();

    $("#validateCustMulti").html('<i class="fa fa-spin fa-spinner"></i> Paying N'+ $('input[name=payMethod]').attr('data-value'));
    $.ajax({
      url: '/tran/makeMultiChoice/PaySub',
      type: 'POST',
      dataType: 'json',
      data: {
        plan: $('input[name=payMethod]').val(),
        _token: $('input[name=_token]').val()

      },

      success: function(data){
        if (data['status'] === 1) {

          swal('Bill Payment', data['message'], 'success');
          $("#validateCustMulti").html("PROCEED");

          location.reload();
        }else{
          $("#validateCustMulti").html("PROCEED");
          swal('Bill Payment', data['message'], 'error');
        }
      }
    });

    });



  </script>

@endpush

