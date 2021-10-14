
<div><span style="float:left; font-size: 12px; font-weight: bold;"> <a href="/tran/paybills?page=billoptionelectric"><i class="fa fa-angle-double-left"></i> Choose Another Utility</a></span><span style="float:right; font-size: 10px; font-weight: bold;"><i class="fa fa-circle text-success"></i> Active</span></div><br><br>
<div id="alert">

</div>
<div class="paymentDetails">

</div>
<div class="mainForm">
    <div id="DataResponse">
        <form id="eedc" accept-charset="utf-8" data-parsley-validate>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon no-padding no-bg no-bd">
                    <i class="ion-person fstylec"></i>
                    </div>
                    <input class="form-control" type="text" value="{{$name}}" readonly name="name">
                    <input type="hidden" name="meter" value="{{$meterNumber}}" />
                    <input type="hidden" name="type" value="{{$service}}" />
                    <input type="hidden" name="productCode" value="{{$productCode}}" />
                </div>
            </div>
            <div>
                <table class="table table-bordered" style="text-align: left; font-size: 11px; width: 80%;">
                    <div class="form-group">
                        <tr>
                            <td align="center"><b>Account Type</b></td><td>{{$type}}</td>
                        </tr>
                    </div>
                </table>
            </div>
            <div>
                <div class="form-group">
                    <table class="table" style="text-align: right; width: 60%;">
                        <tr>
                            <td>Enter Phone Number: </td> <td><input type="number" id="phone" name="phone" required placeholder=" 080XXXXXXXXX "/></td>
                        </tr>
                        <tr>
                            <td>Enter Wallet PIN: </td><td><input type="password" name="pin" required class"pincode-input5" pattern="[0-9]{4}" maxlength="4" placeholder=" Your 4-Digit Pin"/></td>
                        </tr>
                    </table>
                </div>
            </div>
            <input type="hidden" name="view" value="{{ rand() }}" />
            <div class="form-group">
                <button id="" type="submit" class="vendButton btnHide btn-customb btn-block arrow-btn waves-effect waves-classic">
                    <span class="billProceedBtnOne">PAY BILL</span>
                    <span class="arrow"></span>
                </button>
            </div>
        </form>
    </div>
</div>


<script>
     $(document).ready(function(){
    $('form').submit(function(e){
      e.preventDefault();
      // #planSelectFormButton
      $('.vendButton').prop('disabled', true);
      $('div#alert').text('');
      $("div#alert").removeClass("alert");
      $("div#alert").removeClass("alert-success");
      $("div#alert").removeClass("alert-danger");

      $('.billProceedBtnOne').html('<i class="fa fa-spin fa-spinner"></i> PAYING');

      var formData = {};
        $.each($(this).find('input'),function(i,v){
            formData[$(v).attr("name")] = $(v).val();
        });

      var request = new XMLHttpRequest();
      var formDatas = new FormData();
      formDatas.append('productCode', formData.productCode);
      formDatas.append('phone', formData.phone);
      formDatas.append('pin', formData.pin);
      formDatas.append('service', "eedc");

      request.open('post','/api/utility/vas/electricity/pay');
      request.send(formDatas);

      request.onreadystatechange = function() {
      if (request.readyState === 4) {
        if (request.status === 200) {
            const response = JSON.parse(request.responseText)
          $('div#alert').text(response.data.message);
              $("div#alert").addClass("alert");
              $("div#alert").addClass("alert-success");
              $('.billProceedBtnOne').html('PAYMENT SUCCESSFUL');

                const { data } = response.data

              $(".paymentDetails").html(
                `<div class='bg-info mb-4' style="padding: 10px"><strong>Payvice Web EEDC Transaction Details</strong></div>
                <table class="table">
                <tr class="text-left">
                <td>Status:</td>
                <td>Transaction Successful</td>
                </tr>
                <tr class="text-left">
                <td>Customer Name:</td>
                <td>${data.name || ""} </td>
                </tr>
                <tr class="text-left">
                <td>Address:</td>
                <td>${data.address || ""}</td>
                </tr>
                <tr class="text-left">
                <td>Amount:</td>
                <td>N${data.amount}.00</td>
                </tr>
                <tr class="text-left">
                <td>Token:</td>
                <td>${data.token || ""}</td>
                </tr>
                <tr class="text-left">
                <td>Units:</td>
                <td>${data.units || ""}</td>
                </tr>
                <tr class="text-left">
                <td>Meter Number:</td>
                <td>${ $('input[name="meter"]').val() }</td>
                </tr>
                <tr class="text-left">
                <td>Account Type:</td>
                <td>${ data.type || data.account_type || "" }</td>
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
                  $('.billProceedBtnOne').html('PAY FOR SELECTED PLAN');
                $('.vendButton').prop('disabled', false);
              }else{
                const { data } = JSON.parse(request.responseText)
                $('div#alert').text(data.message);
                $("div#alert").addClass("alert");
                $("div#alert").addClass("alert-danger");
                $('.billProceedBtnOne').html('PAY FOR SELECTED PLAN');
                $('.vendButton').prop('disabled', false);
              }

        }
      }else{

      }
    }

    });
});
</script>

