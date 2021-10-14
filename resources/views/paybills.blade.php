@extends('layouts.master')
@section('content')
<script>
function now(){
    window.location.reload(true);
}
document.body.style.overflowY = 'hidden';	
</script>
<div id="wrapper" class="toggled" >

 <div role="navigation" class="wrap-body" id="sidebar-wrapper">
@include('layouts.menu')
    <div class="p-20" id="page-content-wrapper">
      <section>
    @include('layouts.sub-menu')
               <div class="row">
                 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                 <div class="row">
<div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12">
<div id="paybills">
                    <div class="row">

                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php if($_REQUEST['page'] == "billoptiontv") {  ?>
                          <div class="col-lg-12 fillh" id="billoptiontv" >
                          <div class="mb-30">
                          <a class="inline" href="/tran"><i class="ion-home block fstyleic"></i></a>
                          <h4 class="inline right">Cable TV</h4>
                          <hr class="no-margin f-width"/>
                          </div>
                          <div class="utility-slide" id="all_cable_tv">
                              
                                <div><a class="showCableBill" data-img="gotv" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/util_gotv.png') }}" /></a></div>
                                <div><a class="showCableBill" data-img="dstv" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/util_dstv.png') }}" /></a></div>
                                <div><a class="showCableBill" data-img="startime" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/util_startime.png') }}" /></a></div>
                              
                            </div>

                          <div class="">
                            <!-- billstepone -->
                            @include('includes.paybills.show-cable-bill')
                          </div>
                          </div>
                        <?php } ?>

                        <?php if($_REQUEST['page'] == "billoptionint") {  ?>
                          <div class="col-lg-12 fillh" id="billoptionint">
                          <div class="mb-30">
                          <a class="inline" href="/tran"><i class="ion-home block fstyleic"></i></a>
                          <h4 class="inline right">Internet Services</h4>
                          <hr class="no-margin f-width"/>
                          </div>
                              {{-- <div class="utility-slide">
                                <div>
                                  <a class="showInternetBill" data-img="smile" href="#">
                                    <img class="padded-area-v" src="{{ URL::asset('assets/img/util_smile.png') }}" />
                                  </a>
                                </div>
                                <div>
                                    <a class="" href="/tran/data">
                                        <img class="padded-area-v" src="{{ URL::asset('assets/img/networks.jpg') }}" />
                                      </a>
                                </div>
                              </div> --}}
                            <div class="">
                              <div id="alert">

                              </div>
                              <!-- billstepone -->
                              @include('includes.paybills.show-internet-bills')
                            </div>
                          </div>
                        <?php } ?>

                        <?php if($_REQUEST['page'] == "billoptionelectric") {  ?>
                            <div class="col-lg-12 fillh" id="billoptionelectric">
                            <div class="mb-30">
                            <a class="inline" href="/tran"><i class="ion-home block fstyleic"></i></a>
                            <h4 class="inline right">Electricity Bills</h4>
                            <hr class="no-margin f-width"/>
                            </div>
                                <div class="utility-slide" id="utility_bill_list">
                                  <div><a class="showUtilities"  data-img="ikedc" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/util_ikedc.png') }}" /></a></div>

                                  <div><a class="showUtilities" data-img="ekedc" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/util_ekedc.png') }}" /></a></div>

                                  <div><a class="showUtilities" data-img="ibedc" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/util_ibedc.png') }}" /></a></div>

                                  <div><a class="showUtilities" data-img="phed" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/util_phdc.png') }}" /></a></div>  
                              
                                  <div><a class="showUtilities" data-img="eedc" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/util_eedc.png') }}" /></a></div>

                                  <div><a class="showUtilities" data-img="aedc" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/util_aedc.png') }}" /></a></div>

                                  <div><a class="showUtilities" data-img="kedco" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/util_kedco.png') }}" /></a></div>
                                  {{-- <div><img class="padded-area-v" src="{{ URL::asset('assets/img/util_kedco.png') }}" /></div> --}}

                                </div>
                              <br clear="all" /><br clear="all" />
                                <div class="" id="paymentResponse">
                                  <!-- billstepone -->
                                  @include('includes.paybills.show-utility-bill')
                              </div>
                              </div>
                            <?php } ?>
                         
                          <div class="col-lg-12 fillh" id="billoptiontoll">
                          <div class="mb-30">
                          <a class="inline" href="/tran"><i class="ion-home block fstyleic"></i></a>
                          <h4 class="inline right">Toll Fee</h4>
                          <hr class="no-margin f-width"/>
                          </div>
                          <div class="utility-slide">
                          <div><a class="showToll" data-img="lcc" href="#"><img class="padded-area-v" src="{{ URL::asset('assets/img/util_lcc.png') }}" /></a></div>
                          </div>

                          <div class="" id="paymentResponse">
                                <!-- billstepone -->
                                @include('includes.paybills.show-toll-bill')
                          </div>    

                        </div>
                       

                        <div class="col-lg-12 fillh" id="billoptionother">
                        <div class="mb-30">
                        <a class="inline" href="/tran"><i class="ion-home block fstyleic"></i></a>
                        <h4 class="inline right">Others</h4>
                        <hr class="no-margin f-width"/>
                        </div>
                            <div class="utility-slide">
                              <div><img class="padded-area-v" src="{{ URL::asset('assets/img/util_waec.png') }}" /></div>
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
    $('#payMethod_utility').hide();

   // Toll 
   $('#billstepone_toll').hide();
    $('#billsteptwo_toll').hide();
    $('#payMethod_toll').hide();

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
        servImg = 'util_eedc.png';
        servType = "ENUGU ELECTRIC";
        $("#utilRoute").html("<input type=\"hidden\" id=\"utilType\" value=\""+servType+"\" />");
        break;
        case 'phed':
        servImg = 'PHED.png';
        servType = "PORTHARCOURT ELECTRIC";
        $("#utilRoute").html("<input type=\"hidden\" id=\"utilType\" value=\""+servType+"\" />");
        break;
        case 'aedc':
        servImg = 'util_aedc.png';
        servType = "ABUJA ELECTRIC";
        $("#utilRoute").html("<input type=\"hidden\" id=\"utilType\" value=\""+servType+"\" />");
        break;
        case 'kedco':
        servImg = 'util_kedco.png';
        servType = "KANO ELECTRIC";
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


// TOLL
$('.showToll').click(function() {
      var img = $(this).attr('data-img');
      var servImg ="";
      var servType = "";

      switch(img){
        case 'lcc':
        servImg = 'util_lcc';
        servType = "LCC";
        $("#utilRoute").html("<input type=\"hidden\" id=\"utilType\" value=\""+servType+"\" />");
        break;
      }

      $("#serviceIcon_utility").html("<img id=\"telco_imageb\" style='height: 30px!important; width: 50px!important; margin-left: 3px;' src=\"{{ URL::asset('assets/img') }}/"+servImg+"\">");
      $('input[name="utility_unit"]').attr({'readonly': true, 'value': servType}).val(servType).removeAttr('placeholder');
      // Show slides
      $('#billstepone_toll').fadeIn("slow");
      // Hide Others
      $('#billstepone_internet').hide();
      $('#billstepone_internet').hide();
      $('#billstepone_cable').hide();
      return false;
    });

    //CableTV
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


    //end
  });

  // Submit CableBill Form 
  $("#cableBill").submit(function (e) {
        e.preventDefault();
        $('#all_cable_tv').hide();
        var spintext = 'Validating IUC Number';
        submit_form('cableBill', "{{ route('validateIUC') }}", spintext, 'cableResponse', 'subPlan_cable', false);
  });

  // billoptionutil
  $("#utilOption").submit(function (e) {
        e.preventDefault();
        $('#utility_bill_list').hide()
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
        } else if (utilType == 'ABUJA ELECTRIC'){
          submit_form('utilOption', "{{ route('meterAELookup') }}", spintext, 'utilityResponse', 'subPlan_utility', false);
        }  else if (utilType == 'KANO ELECTRIC'){
          submit_form('utilOption', "{{ route('meterKELookup') }}", spintext, 'utilityResponse', 'subPlan_utility', false);
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

    $(document).on('submit', 'form#cableTvPayBill', function(event) {
      event.preventDefault();
      // #planSelectFormButton
      $('.cableTvPayBillBtn').prop('disabled', true);
      $('div#alert').text('');
      $("div#alert").removeClass("alert");
      $("div#alert").removeClass("alert-success");
      $("div#alert").removeClass("alert-danger");

      $('.billProceedBtnOne').html('<i class="fa fa-spin fa-spinner"></i> PAYING');

      var forms = document.querySelector('form#cableTvPayBill');
      var request = new XMLHttpRequest();
      var formDatas = new FormData(forms);

      request.open('post','/api/multichoice/vas/pay');
      request.send(formDatas);

      request.onreadystatechange = function() {
      if (request.readyState === 4) {
        const response = JSON.parse(request.responseText)
        if (request.status === 200) {
          $('div#alert').text(response.data.message);
              $("div#alert").addClass("alert");
              $("div#alert").addClass("alert-success");
              $('.billProceedBtnOne').html('PAYMENT SUCCESSFUL');

              const { data } = response.data

                $(".paymentDetails").html(
                  `<div class='bg-info mb-4' style="padding: 10px"><strong>Payvice Web MULTICHOICE Transaction Details</strong></div>
                  <table class="table">
                  <tr class="text-left">
                  <td>Status:</td>
                  <td>Transaction Successful</td>
                  </tr>
                  <tr class="text-left">
                  <td>Bouquet Name:</td>
                  <td>${data.bouquetName || data.bouquet || ""} </td>
                  </tr>
                  <tr class="text-left">
                  <td>Account:</td>
                  <td>${data.account || data.smartCardCode || ""} </td>
                  </tr>
                  <tr class="text-left">
                  <td>Amount Paid:</td>
                  <td>N${data.amount}.00</td>
                  </tr>
                  <tr class="text-left">
                  <td>Transaction Reference:</td>
                  <td>${data.reference}</td>
                  </tr>
                  <tr class="text-left">
                  <td>Transaction Sequence:</td>
                  <td>${data.sequence}</td>
                  </tr>
                  </table>
                </table>
                <div id="clearPurchase" class="btn btn-info">Refresh</div>
                  `
                );
                $(document).on('click', '#clearPurchase', function(event) {
                    event.preventDefault(); 
                    var url = '/tran'
                    window.location = url
                });
                $('#cableTvPayBill').hide();

              // var delay = 5000; 
              // var url = '/tran/paybills?page=billoptiontv'
              // setTimeout(function(){ window.location = url; }, delay);
        }else{
          $('div#alert').text(response.data.message);
          $("div#alert").addClass("alert");
          $("div#alert").addClass("alert-danger");
          $('#spinner').hide();
          $('.billProceedBtnOne').html('PAY FOR SELECTED PLAN');
          $('.cableTvPayBillBtn').prop('disabled', false);
        }
      }else{

      }
    }

    });



  </script>

@endpush

