<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="keywords" content="">

  <title>UBA Agency Banking - API Documentation</title>

  <!-- Styles -->
  <link href="{{ URL::asset('api/assets/css/theDocs.all.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('api/assets/css/custom.css') }}" rel="stylesheet">

  <!-- Favicons -->
  <link rel="icon" href="{{ URL::asset('assets/img/favicon.ico') }}" type="image/x-icon">
</head>

<body data-spy="scroll" data-target=".sidebar" data-offset="200">


  <header class="site-header navbar-transparent">

    <!-- Banner -->
    <div class="banner auto-size" style="background-color: #5cc7b2">
      <div class="container-fluid text-white">
        <h1 style="padding: 15px 0px; text-align: center;"><strong>UBA Agency BAnking - </strong> API implementation</h1>
        <h5 style="text-align: center;">A Guide for Developers</h5>
      </div>
    </div>
    <!-- END Banner -->

  </header>

  <main class="container-fluid">

    <!-- Main content -->
    <article class="main-content" role="main">

      <section>
        <h2 id="introduction">Consumming the API</h2>
        <p>
          To consume UBA Agency Banking api you will need to do a base64 encode of the userid and password and add it to the request payload with its key as "auth".
          <br>
          Examplle using PHP: <br>
          <code>base64_encode("userid:password")</code>
          <br>

        </p>


      </section>


      <section>
        <h2 id="name-enquiry">Name Enquiry</h2>
        <p>
          The name enquiry service is used to validate a customer's account and use the response information from the request.
        </p>
        <p>
          <h5>Request Parameter</h5>
          <code> account_number </code> - Customer's Account Number <br>
        </p>

        <h4 id="title1">Sample Request</h4>

        <pre class="">
          <code class="language-markup">
            BODY: 

            {
              "account_number" => "2097393339"
            }


            URL:        http://172.20.232.19/tams/agency/nameenquiry.php
            HTTP VERB:  POST
          </code>
        </pre>

        <h4 id="title1">Sample Response</h4>
        <pre>
          <code class="language-markup">

            {
              "error": false,
              "name": "ETAIEBENU, CANAAN OKEOGHENE",
              "phone": "08163240721",
              "cust_id": "R001824594"
            }

          </code>
        </pre>

      </section>

      <section>
        <h2 id="send-otp">Send OTP</h2>
        <p>
          This service is used to send authentication code to customer to authenticate the transaction request.
        </p>
        <p>
          <h5>Request Parameter</h5>
          <code> type </code> - "gen" to generate and send otp to phone number attached to the account<br>
          <code> cust_id </code> - Account number of the customer<br>
          <code> tran_type </code> - Type of transaction (cashIn, cashOut and transfer).<br>
        </p>

        <h4 id="title1">Sample Request</h4>

        <pre class="">
          <code class="language-markup">
            BODY:

            {

              "type" => "gen", 
              "cust_id" => "xxxxxx", 
              "tran_type" => "cashOut"
            }


            URL:        http://172.20.232.19/tams/agency/otp.php
            HTTP VERB:  POST
          </code>
        </pre>

        <h4 id="title1">Sample Response</h4>
        <pre>
          <code class="language-markup">
            {
              "error": false,
              "message": "OTP successfully sent to Phone"
            }
          </code>
        </pre>

      </section>

      <section>
        <h2 id="auth-otp">Authenticate OTP</h2>
        <p>
          This service is used to authentication the code that was sent to customer to authenticate the transaction request.
        </p>
        <p>
          <h5>Request Parameter</h5>
          <code> type </code> - "gen" to generate and send otp to phone number attached to the account<br>
          <code> cust_id </code> - Account number of the customer<br>
          <code> tran_type </code> - Type of transaction (cashIn, cashOut and transfer).<br>
          <code> otp </code> - OTP received on account holder's phone via sms.<br>
        </p>

        <h4 id="title1">Sample Request</h4>

        <pre class="">
          <code class="language-markup">
            BODY: 

            {
              "type" => "gen", 
              "cust_id" => "xxxxxx", 
              "tran_type" => "cashOut", 
              "otp": "12345678"
            }


            URL:        http://172.20.232.19/tams/agency/otp.php
            HTTP VERB:  POST
          </code>
        </pre>

        <h4 id="title1">Sample Response</h4>
        <pre>
          <code class="language-markup">
            {
              "error": false,
              "message": "OTP authenticated successfully for AGENCY BANKING in group Nigeria"
            }
          </code>
        </pre>

      </section>

      <section>
        <h2 id="auth-token">Authenticate TOKEN</h2>
        <p>
          This service is used to authentication the code that was sent to customer to authenticate the transaction request.
        </p>
        <p>
          <h5>Request Parameter</h5>
          <code> toke </code> - The generated token from the hardware token device<br>
          <code> cust_id </code> - Account number of the customer<br>
          <code> tran_type </code> - Type of transaction (cashIn, cashOut and transfer).<br>
        </p>

        <h4 id="title1">Sample Request</h4>

        <pre class="">
          <code class="language-markup">
            BODY: 

            {
              "token" => "12345678", 
              "cust_id" => "xxxxxx", 
              "tran_type" => "cashOut"
            }


            URL:        http://172.20.232.19/tams/agency/token.php
            HTTP VERB:  POST
          </code>
        </pre>

        <h4 id="title1">Sample Response</h4>
        <pre>
          <code class="language-markup">
            {
              "error": false,
              "message": "TOKEN authenticated successfully for AGENCY BANKING in group Nigeria"
            }
          </code>
        </pre>

      </section>

      <section>
        <h2 id="bvn">BVN Validation</h2>
        <p>
          This service is used to validate and get customer's information using bvn.
        </p>
        <p>
          <h5>Request Parameter</h5>
          <code> bvn </code> - customer's bvn<br>
        </p>

        <h4 id="title1">Sample Request</h4>

        <pre class="">
          <code class="language-markup">
            BODY: {"bvn": "12345678901"}


            URL:        http://172.20.232.19/tams/agency/validate_bvn.php.php
            HTTP VERB:  POST
          </code>
        </pre>

        <h4 id="title1">Sample Response</h4>
        <pre>
          <code class="language-markup">
            {
              "ResponseCode": "00",
              "ResponseMessage": "BVN Validation Succesful",
              "dob": "20-Aug-82",
              "phone": "080xxxxxxxx",
              "Lastname": "Doe",
              "Middlename": "",
              "Firstname": "John"
            }
          </code>
        </pre>

      </section>

      <section>
        <h2 id="cashin">CASHIN Transaction</h2>
        <p>
          This service is used for <b>CASHIN</b> transactions.
        </p>
        <p>
          <h5>Request Parameter</h5>
          <code> accNum </code> - customer's account number<br>
          <code> account_name </code> - customer's account account name (name you got from "name enquiry")<br>
          <code> amount </code> - Transaction amount<br>
          <code> phone </code> - customer's account account name (name you got from "name enquiry" or manually entered)<br>
          <code> requestType </code> - Type of transaction<br>
          <code> auth </code> - base64 encode of userid and password (eg. username:password)<br>
        </p>

        <h4 id="title1">Sample Request</h4>

        <pre class="">
          <code class="language-markup">
            BODY: 

            {
              "accNum": "2035846664", 
              "account_number":"EBERE INNOCENT AHAOTU", 
              "amount": "2000", 
              "phone": "2348057463738", "requestType": "cashIn", 
              "auth":"MTAxMjMwNDU2MjpwYXNzd29yRDU1"
            }


            URL:        http://172.20.232.19/tams/agency/api.php
            HTTP VERB:  POST
          </code>
        </pre>

        <h4 id="title1">Sample Response</h4>
        <pre>
          <code class="language-markup">
            {
              "error": false,
              "message": "Cashin Successful!"
            }
          </code>
        </pre>

      </section>

      <section>
        <h2 id="cashout">CASHOUT Transaction</h2>
        <p>
          This service is used for <b>CASHOUT</b> transactions.
        </p>
        <p>
          <h5>Request Parameter</h5>
          <code> accNum </code> - customer's account number<br>
          <code> account_name </code> - customer's account account name (name you got from "name enquiry")<br>
          <code> amount </code> - Transaction amount<br>
          <code> phone </code> - customer's account account name (name you got from "name enquiry" or manually entered)<br>
          <code> requestType </code> - Type of transaction<br>
          <code> auth </code> - base64 encode of userid and password (eg. username:password)<br>
        </p>

        <h4 id="title1">Sample Request</h4>

        <pre class="">
          <code class="language-markup">
            BODY: 

            {
              "accNum": "2035846664", 
              "account_number":"EBERE INNOCENT AHAOTU", 
              "amount": "1000", 
              "phone": "2348057463738", "requestType": "cashOut", 
              "auth":"MTAxMjMwNDU2MjpwYXNzd29yRDU1"
            }


            URL:        http://172.20.232.19/tams/agency/api.php
            HTTP VERB:  POST
          </code>
        </pre>

        <h4 id="title1">Sample Response</h4>
        <pre>
          <code class="language-markup">
            {
              "error": false,
              "message": "Cashout Successful!"
            }
          </code>
        </pre>

      </section>

      <section>
        <h2 id="transfer">CASH TRANSFER [ INTRA-BANK ]</h2>
        <p>
          This service is used for <b>CASH TRANSFER - UBA to UBA</b> transactions.
        </p>
        <p>
          <h5>Request Parameter</h5>
          <code> account_name </code> - customer's account account name (name you got from "name enquiry")<br>
          <code> Amount </code> - Transaction amount<br>
          <code> frmAcc </code> - Account you want to transfer money from<br>
          <code> toAcc </code> - Account you want to transfer money to<br>
          <code> sndPhone </code> - Phone number of sender<br>
          <code> rcvPhone </code> - Phone number of receiver<br>
          <code> naration </code> - Narration of transaction<br>
          <code> requestType </code> - Type of transaction<br>
          <code> auth </code> - base64 encode of userid and password (eg. username:password)<br>
        </p>

        <h4 id="title1">Sample Request</h4>

        <pre class="">
          <code class="language-markup">
            BODY: 

            {

              "account_number":"EBERE INNOCENT AHAOTU", 
              "Amount": "1500", 
              "frmAcc": "2035846664", 
              "toAcc": "1012304562", "sndPhone": "2348057463738", 
              "rcvPhone": "2348057463738", 
              "naration": "transfer for house rent", 
              "requestType": "cashOut", 
              "auth":"MTAxMjMwNDU2MjpwYXNzd29yRDU1"
            }


            URL:        http://172.20.232.19/tams/agency/api.php
            HTTP VERB:  POST
          </code>
        </pre>

        <h4 id="title1">Sample Response</h4>
        <pre>
          <code class="language-markup">
            {
              "error": false,
              "message": "Cash Transfer Successful!"
            }
          </code>
        </pre>

        <h2 id="transfer">CASH TRANSFER [ INTER-BANK ]</h2>
        <p>
          This service is used for <b>CASH TRANSFER - UBA to Other Banks</b> transactions.
        </p>
        <p>
          <h5>Request Parameter</h5>
          <code> bankCode </code> - Indicate the bank code of the receiver<br>
          <code> toAccount </code> - Beneficiary account number<br>
          <code> transferType </code> - To indicate that the transfer type to other bank<br>
          <code> fromAccount </code> - Sender's account number (UBA account)<br>
          <code> toAccountName </code> - Beneficiary account number<br>
          <code> narration </code> - Description of the transafer<br>
          <code> amount </code> - Transaction amount<br>
          <code>senderPhone</code> - The phone number of the sender
          <code>receiverPhone</code> - Beneficiary phone number
          <code> actionType </code> - Eithe "requery" to indicate that this is to requery a previous transaction or "transfer" for financial request<br>
          <code> transactionRef </code> - The reference of the previous transaction to requery or null in the case of transfer request<br>
          <code> auth </code> - base64 encode of userid and password (eg. username:password)<br>
        </p>

        <h4 id="title1">Sample Request</h4>

        <pre class="">
          <code class="language-markup">
            BODY: 

            {
              "bankCode": "058",
              "toAccount" : "01xxxxx950", 
              "transferType" : "interbank",
              "fromAccount" : "208xxxx893",
              "toAccountName" : "John Doe",
              "narration" : "Thank God is Tuesday",
              "amount" : "100",
              "senderPhone": "081xxxxxxxx23",
              "receiverPhone": "080xxxxxx600"
              "actionType" : "requery",
              "transactionRef" : "5C6C0DF58EC6A"
              "auth":"MTAxMjMwNDU2MjpwYXNzd29yRDU1"
            }


            URL:        http://172.20.232.19/tams/agency/api.php
            HTTP VERB:  POST
          </code>
        </pre>

        <h4 id="title1">Sample Response</h4>
        <pre>
          <code class="language-markup">
            {
              "error": false,
              "message": "Cash Transfer Successful!"
            }
          </code>
        </pre>

      </section>

      <h2 id="html-getBranch">GET BRANCHES LIST</h2>
      <p>
        This service is used to get list of <b>BRANCHES</b> to enable customer select a branch of his choice.
      </p>
      <p>
        <h5>Request Parameter</h5>
        <code> getBranches </code><br>
      </p>

      <h4 id="title1">Sample Request</h4>

      <pre class="">
        <code class="language-markup">
          BODY: {"requestType": "getBranches", "auth":"MTAxMjMwNDU2MjpwYXNzd29yRDU1"}


          URL:        http://172.20.232.19/tams/agency/api.php
          HTTP VERB:  POST
        </code>
      </pre>

      <h4 id="title1">Sample Response</h4>
      <pre>
        <code class="language-markup">
          [{
          "bran_code": "0001",
          "branch_name": "33B BISHOP ABOYADE COLE STREET, VI, LAGOS"
        }]
      </code>
    </pre>

  </section>

  <section>
    <h2 id="account-opening">ACCOUNT OPENING</h2>
    <p>
      This service is used for <b>ACCOUNT OPENING</b>.
    </p>
    <p>
      <h5>Request Parameter</h5>
      <code> bvn </code> - customer's BVN<br>
      <code> fName </code> - First name<br>
      <code> lName </code> - Last name<br>
      <code> mName </code> - Middle name<br>
      <code> address </code> - Customer's residential address<br>
      <code> email </code> - Customer's email address<br>
      <code> phone </code> - Customer's phone number<br>
      <code> dob </code> - Customer's date of birth<br>
      <code> gender </code> - Customer's Gender (M, F, O)<br>
      <code> title </code> - Customer's Title (Mr, Mrs, e.t.c)<br>
      <code> state </code> - Customer's State<br>
      <code> city </code> - Customer's city<br>
      <code> occupation </code> - Customer's occupation<br>
      <code> marital </code> - Customer's marital status<br>
      <code> acct_type </code> - Account type ( 1 = savings, 2 = current )<br>
      <code> requestType </code> - open<br>
      <code> branch </code> - The selected branch from "getBranches" call<br>
      <code> auth </code> - encoded authentication string<br>
    </p>

    <h4 id="title1">Sample Request</h4>

    <pre class="">
      <code class="language-markup">
        BODY: 

        {

          "bvn": "123456789012", 
          "fName":"EBERE", 
          "lName": "AHAOTU", 
          "mName": "INNOCENT", 
          "address": "21B uba house", 
          "email": "johndoe@example.com", "phone": "2348057463738", 
          "dob": "20/10/1988", 
          "gender": "M", 
          "title": "Mr", 
          "state": "035", 
          "city": "039", "occupation": "Software Developer", 
          "marital": "002", 
          "acct_type": "1", 
          "requestType": "open", 
          "branch": "XXXX"
          "auth":"MTAxMjMwNDU2MjpwYXNzd29yRDU1"
        }


        URL:        http://172.20.232.19/tams/agency/api.php
        HTTP VERB:  POST
      </code>
    </pre>

    <h4 id="title1">Sample Response</h4>
    <pre>
      <code class="language-markup">
        {
          "error": false,
          "message": "Account Opening Successful!",
          "account_number": "2097396024",
          "cifid": "R001824994"
        }
      </code>
    </pre>

  </section>

</article>
<!-- END Main content -->
</main>


<!-- Footer -->
<footer class="site-footer">
  <div class="container-fluid">
    <a id="scroll-up" href="#"><i class="fa fa-angle-up"></i></a>

    <div class="row">
      <div class="col-md-6 col-sm-6">
        <p>Copyright &copy; 2019. All right reserved</p>
      </div>
      <div class="col-md-6 col-sm-6">
        <ul class="footer-menu">
          <li><a href="#">Changelog</a></li>
          <li><a href="#">Credits</a></li>
          <li><a href="#">Contact us</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
<!-- END Footer -->

<!-- Scripts -->
<script src="{{ URL::asset('api/assets/js/theDocs.all.min.js') }}"></script>
<script src="{{ URL::asset('api/assets/js/custom.js') }}"></script>

</body>
</html>
