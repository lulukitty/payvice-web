
<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-12 col-xs-12">
    <div id="billstepone_internet_smile" class="panel mt-30 bordered panel-default showdisappear">
        <div class="panel-body p-30">
          <form action="#" method="POST" accept-charset="utf-8" id="internet_billStepOne" data-parsley-validate>
                <div class=" form-group">
                      <i class="ion-ios-paper-outline fstylec"></i>
                    {{-- <input placeholder="Cable TV Selected" class="form-control" type="text" required name="cTv_internet"> --}}
                    <input placeholder="SMILE INTERNET" class="form-control" type="text" required name="cTv_internet" disabled>
                    <div style="width:50px" class="input-group-addon no-padding no-bg no-bd" id="serviceIcon_internet">
                      <img src="{{ URL::asset('assets/img/util_smile.png') }}" />
                    </div>
                    <input type="hidden" name="biller">
                </div>

                <div class=" form-group-b">
                      <i class="ion-person fstylec"></i>
                    <input placeholder="SMART CARD NUMBER" class="form-control" type="text" required min="11" name="card">
                  </div>
                <br/>
                <div class="form-group">
                  <button id="validateInternet" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                    <span class="billProceedBtnOne">PROCEED</span>
                    <span class="arrow"></span>
                </button>
              </div>
        </form> <!-- swapBillAuthForm -->
      </div>
  </div>
  </div>
  </div>  {{-- --end col-lg-8 --}}

 {{-- --end row --}}

{{-- <div class="row">
  <div class="col-lg-2 col-md-2 col-sm-1 xs-hidden col-xs-12"></div>
  <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">

    <div id="payMethod" class="panel panel-default no-bd shadow" style="display: none;">

    <div class="panel-heading text-center">
      <p class="fg-blue">Wallet Ballance</p>
      <h1 class="bold no-margin fg-green"> 1,804.84</h1>
      <h6 class="fg-blue">Wallet ID : 57571362</h6>
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

  </div>
  <div class="col-lg-2 col-md-2 col-sm-1 xs-hidden col-xs-12"></div>
  </div> --}}


<!-- Authenticate bill-payment -->

<div class="row">
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
  <div id="billsteptwo_internet" class="panel panel-default  no-bd shadow">
    {{-- <img class="padded-area-v" src="{{ URL::asset('assets/img/util_smile.png') }}" /> --}}

    <div class="paymentDetails text-center p-2">
      
    </div>

      <div class="mainForm panel-body no-padding">
        <form class="no-margin" id="paySmile" data-parsley-validate="" novalidate>
          <div class="panel-body text-center">
            <h4>Customer Name</h4>
            <div class="customerName">

            </div>
          </div>
          <div class="panel panel-default no-margin">
            <div class="panel-body text-center">
              <select  id="bundle-list" name="selectedBundle" class="form-control p-2" required>
                <option value="">Select a Bundle</option>
              </select>
            </div>
            <input type="hidden" name="productCode">

            <div class="panel-body text-center">
              <input placeholder="Enter Phone Number" class="form-control p-2" type="number" name="phone" required>
            </div>

            <div class="panel-body text-center">
              <P class="medium">This is your 4 personal digit PIN needed to complete this transaction</P>
            </div>
            <div class="panel-footer no-bd">
              <div class=" form-group">

                <input type="text" style="margin:0px auto" class="pincode-input5"  name="pin" >


              </div>

              <br>
              <div class="form-group ">
                <button id="pinProceed" type="submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
                  <span class="payBtn">PAY</span>
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
<script>
$(document).ready(function() {
   $('#validateInternet').on('click', function(event) {
      event.preventDefault();
      // #planSelectFormButton
      $('#validateInternet').prop('disabled', true);
      $('div#alert').text('');
      $("div#alert").removeClass("alert");
      $("div#alert").removeClass("alert-success");
      $("div#alert").removeClass("alert-danger");

      $('.billProceedBtnOne').html('<i class="fa fa-spin fa-spinner"></i> PAYING');

      var forms = document.querySelector('form#internet_billStepOne');
      var request = new XMLHttpRequest();
      var formDatas = new FormData(forms);

      request.open('post','/api/internet/smile/validate');
      request.send(formDatas);

      request.onreadystatechange = function() {
      if (request.readyState === 4) {
        if (request.status === 200) {          
          const response = JSON.parse(request.responseText);
          const {data} = response.data
          $('div#alert').text(response.data.message);
              $("div#alert").addClass("alert");
              $("div#alert").addClass("alert-success");

              $.each(data.bundles, function( index, value ) {
                  $('#bundle-list').append('<option class="p-2" value="'+ value.code +'">' + value.name + ' | Amount: N' + value.price + ' | Duration: ' + value.validity + '</option>')
                });

              $('#billsteptwo_internet').fadeIn("slow");
              $('#billstepone_internet_smile').hide();

              $('input[name="productCode"]').val(data.productCode)
              $('.customerName').html(data.customerName)

        }else{
          if(request.status === 404 || request.status === 500){
              $('div#alert').text(request.statusText);
              $("div#alert").addClass("alert");
              $("div#alert").addClass("alert-danger");
              $('.billProceedBtnOne').html('PROCEED');
              $('#validateInternet').prop('disabled', false);
          }else{
            const { data } = JSON.parse(request.responseText)
            $('div#alert').text(data.message);
            $("div#alert").addClass("alert");
            $("div#alert").addClass("alert-danger");
            $('.billProceedBtnOne').html('PROCEED');
            $('#validateInternet').prop('disabled', false);
          }         
        }
      }else{

      }
    }

    });

    //payment
    $('#pinProceed').on('click', function(event) {
      event.preventDefault();
      // #planSelectFormButton
      $('#pinProceed').prop('disabled', true);
      $('div#alert').text('');
      $("div#alert").removeClass("alert");
      $("div#alert").removeClass("alert-success");
      $("div#alert").removeClass("alert-danger");

      $('.payBtn').html('<i class="fa fa-spin fa-spinner"></i> PAYING');

      var forms = document.querySelector('form#paySmile');
      var request = new XMLHttpRequest();
      var formDatas = new FormData(forms);

      request.open('post','/api/internet/smile/pay');
      request.send(formDatas);

      request.onreadystatechange = function() {
      if (request.readyState === 4) {
        if (request.status === 200) {          
          const response = JSON.parse(request.responseText)
          $('div#alert').text(response.data.message);
              $("div#alert").addClass("alert");
              $("div#alert").addClass("alert-success");

              const { data } = response.data

                $(".paymentDetails").html(
                  `<div class='bg-info mb-4' style="padding: 10px"><strong>Payvice Web SMILE Transaction Details</strong></div>
                  <table class="table">
                  <tr class="text-left">
                  <td>Transaction Id:</td>
                  <td>${data.transactionID || ""} Purchase</td>
                  </tr>
                  <tr class="text-left">
                  <td>Amount:</td>
                  <td>N${data.amount}.00</td>
                  </tr>
                  <tr class="text-left">
                  <td>Bundle:</td>
                  <td>${data.bundle || ""}</td>
                  </tr>
                  <tr class="text-left">
                  <td>Transaction Reference:</td>
                  <td>${data.reference}</td>
                  </tr>
                  <tr class="text-left">
                  <td>Status:</td>
                  <td>Transaction Successful</td>
                  </tr>
                </table>
                <div id="clearPurchase" class="btn btn-info">Refresh</div>
                  `
                );
                $(document).on('click', '#clearPurchase', function(event) {
                  event.preventDefault(); 
                  var url = '/tran'
                  window.location = url
                });
                $('.mainForm').hide();

        }else{
          if(request.status === 404 || request.status === 500){
              $('div#alert').text(request.statusText);
              $("div#alert").addClass("alert");
              $("div#alert").addClass("alert-danger");
              $('.payBtn').html('PAY');
              $('#pinProceed').prop('disabled', false);
          }else{
            const { data } = JSON.parse(request.responseText)
            $('div#alert').text(data.message);
            $("div#alert").addClass("alert");
            $("div#alert").addClass("alert-danger");
            $('.payBtn').html('PAY');
            $('#pinProceed').prop('disabled', false);
          }         
        }
      }else{

      }
    }

    });
});
</script>
