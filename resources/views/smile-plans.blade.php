<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/sweetalert.css') }}">

@if(null != $error)

{{ $error }}

@else

<div id="UserPin" class="panel panel-default" style="display: none;">
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




<div id="UserChoice" class="panel panel-default" style="display: none;">

 <div class="panel-heading text-center">
   <p class="fg-blue">Wallet Ballance</p>
   <h1 class="bold no-margin fg-green"></h1>
   <h6 class="fg-blue">Wallet ID : {{ Session::get('curAcc') }}</h6>
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

<div id="planForm">
  @if(null != $name)
  <div class="alert alert-success">
    <h4>{{ $name }}</h4>
  </div>
  @endif
  <form action="#" method="POST" id="planSelectForm">
    <ul class="list-group shadow">
      @foreach($plans as $plan)
      <li class="list-group-item">
        <label class="radio labelchk no-margin no-bg">
          <input type="radio" class="rel-radioright" name="payMethodPlan" data-value="{{ $plan['displayPrice'] }}" value="{{ $plan['code'] }}" data-code="{{ $plan['code'] }}">
          <spam class="imgchkk">
            <img src="{{ URL::asset('assets/img/payvice_logob.png') }}">
          </spam>   
          <span>{{ $plan['name'].' - N'.number_format(($plan['displayPrice']/100), 2) }}</span>
        </label>
      </li>
      @endforeach

    </ul>

    <div class="form-group">
      <input type="hidden" name="_tokenPlan" value="{{ csrf_token() }}">
      <button type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic proceedMC">
        <span class="validateCustMulti">PROCEED</span>
      <span class="arrow"></span>
    </button>     
  </div>
</form>
</div>

@endif

<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-pincode-input.js') }}"></script>
<script src="{{ URL::asset('js/sweetalert.min.js') }}"></script>
<script>
$('.proceedMC').on('click', function(event) {
  event.preventDefault();

  /*if ($('input[name=payMethod]').attr('checked') != true) {
    alert("Please select a subscription plan");
  }else{*/
    var planSlt = $('input[checked]').attr('data-value'),
    planAmt = $('input[checked]').attr('data-code');
    $('.validateCustMulti').html('<i class="fa fa-spin fa-spinner"></i> PROCESSING...');
    $.ajax({
      url: '/vice/smile/proceed',
      type: 'POST',
      dataType: 'json',
      data: {

        _token: $('input[name=_tokenPlan]').val(),
        plan:   $('input[name=payMethodPlan]').val(),
        price: planAmt
      },
      success: function(result){
        if (result['status'] === 1) {
          $('#planForm').fadeOut('slow', function() {
            $('#UserPin').fadeIn('fast');
          });
        };
      }

    });

  });


$('#showmenu').on('click', function(event) {
  event.preventDefault();

  if ($('input[name=payMethod]').val() === "") {
    alert("Please Select your payment method");
  }else{
    $('.payBtnLst').html('<i class="fa fa-spin fa-spinner"></i> PROCESSING PAYMENT...');
    $.ajax({
      url: '/vice/proceed/pay',
      type: 'POST',
      dataType: 'json',
      data: {

        _token: $('input[name=_tokenPlan]').val(),
        method:   $('input[name=payMethod]').val()
      },
      success: function(result){
        if (result['status'] === 1) {
          swal('Internet subscribtion', result['message'], 'success');
        }else{
          swal('Internet subscribtion', result['message'], 'error');
        };

        setTimeout(function() {
          location.reload();
        }, 2000);
      }

    });
    
  };

});

$('#pinProceed').on('click', function(event) {
  event.preventDefault();

  if ($('input[name=pin]').val().length < 1) {
    alert("Please enter your transaction pin");
  }else{
    $('.payBtn').html('<i class="fa fa-spin fa-spinner"></i> PROCESSING...');
    $.ajax({
      url: '/vice/proceed/pin',
      type: 'POST',
      dataType: 'json',
      data: {

        _token: $('input[name=_tokenPlan]').val(),
        pin:   $('input[name=pin]').val()
      },
      success: function(result){
        if (result['status'] === 1) {
          $('#UserPin').fadeOut('slow', function() {
            $('#UserChoice').fadeIn('fast');
          });
        };
      }

    });
    
  };

});


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
