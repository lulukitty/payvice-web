<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="keywords" content="API Doc, VAS, Pay bills, Airtime, DSTV, Nigeria, Internet subscription, Top up">
  <meta name="author" content="Michel Kalavanda">

  <title>Payvice - API Documentation</title>

  <!-- Styles -->
  <link href="{{ URL::asset('api/assets/css/theDocs.all.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('api/assets/css/custom.css') }}" rel="stylesheet">

  <!-- Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Raleway:100,300,400,500%7CLato:300,400' rel='stylesheet' type='text/css'>

  <!-- Favicons -->
  <link rel="icon" href="{{ URL::asset('assets/img/favicon.ico') }}" type="image/x-icon">
</head>

<body data-spy="scroll" data-target=".sidebar" data-offset="200">


  <!-- Sidebar -->
  <aside class="sidebar sidebar-boxed sidebar-dark">

    <a class="sidebar-brand" href="/"><img class="logo-light" src="{{ URL::asset('assets/img/logo.png') }}" alt=""></a>

    <ul class="nav sidenav dropable">
      <li><a href="#html-structure">VAS Lookup</a></li>
      <li><a href="#variations">Lookup Response</a></li>

      <li>
        <a href="#title1">Purchase Request</a>
        <ul>
          <li><a href="#subtitle1">HTTP REST</a></li>
          <li>
            <a href="#subtitle2">Topup Response</a>
          </li>
          <li><a href="#subtitle3">IE Name Validation</a></li>
          <li><a href="#subtitle4">IE Validation Response</a></li>
          <li><a href="#subtitle5">IE Purchase Request</a></li>
          <li><a href="#subtitle6">IE Purchase Response</a></li>
          <li>
              <a href="#enuguelectricity">Enugu Electricity</a>
              <ul>
                <li><a href="#validate_enugu">Validation</a></li>
                <li><a href="#validate_pay">Payment</a></li>
              </ul>
          </li>
          <li>
            <a href="#multichoice">Multichoice</a>
            <ul>
              <li><a href="#plans">Get Plans</a></li>
              <li><a href="#account">Validate Account</a></li>
              <li><a href="#pay">Subscribe</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="#transfer">Wallet-to-Wallet Transfer</a></li>
      <li><a href="#title2">Possible Errors</a></li>
      <li><a href="#requery">Requerying Transaction</a></li>
    </ul>

  </aside>
  <!-- END Sidebar -->


  <header class="site-header navbar-transparent">

    <!-- Banner -->
    <div class="banner auto-size" style="background-color: #5cc7b2">
      <div class="container-fluid text-white">
        <h1><strong>Payvice - </strong> VAS API implementation</h1>
        <h5>A Guide for Developers</h5>
      </div>
    </div>
    <!-- END Banner -->

  </header>

  <main class="container-fluid">

    <!-- Main content -->
    <article class="main-content" role="main">

      <p class="lead">

        Payvice offers various Value Added Services (VAS), ranging from Airtime purchase, Bill payment, Toll Gate fee, Internet subscription to Cable TV. The lines below serve as a guidance to third party application willing to consume Payvice services over HTTP REST API or other protocol supported.
      </p>

      <section>
        <h2 id="html-structure">Consuming the API</h2>
        <p>While this page is enough to see through its code and get you started with, you will need to signup to https://www.payvice.com to get your wallet ID and login credentials. Sure you would have obtained your payvice credentials <code>Wallet ID</code>, <code>Username</code> and <code>Password</code>.</p>



        <h2>HTTP POST Request - REST</h2>
        <p>
          To consume Payvice API, the following two steps are required:
          <code>LOOKUP</code> call and <code>PURCHASE</code> for the topup
        </p>
        <h3>Lookup</h3>
        <pre class="">
          <code class="language-markup">
            <br>
            <br>
            { 

            "vice_id": YOUR_WALLET_ID, 
            "user_name": YOUR_PAYVICE_USERNAME 
          }

          URL:        https://www.payvice.com/api/tran/auth2/lookup  
          HTTP VERB:  POST


        </code>
      </pre>

    </section>


    <section>
      <h2 id="variations">Lookup Response</h2>
      <p>
        The lookup call is use to generate a request <code> TOKEN </code> which has a lifespan of two minutes and will be used to validate a purchase request. On successful <code> LOOKUP </code> request, below response will be sent. Keep your <code> TOKEN </code> and make sure the <code> PURCHASE </code> request is sent within the lifespan of your generated token - 2 minutes.
      </p>
      <pre class="">
        <code class="language-markup">



          {
          "vice_id": "12345xxx",
          "token": "474eef6dca8dd57xxxxxxxxxx******xxxxxxxxxx077834b61f6b1",
          "status": 0,
          "message": "Authenticated successfully"
        }



      </code>
    </pre>

  </section>


  <section>
    <h2 id="title1">Purchase Request Parameters</h2>
    <p>
      After a successful <code> LOOKUP </code> request, as earlier stated - within the two-minute lifespan of your token, the sample code below demonstrate how to call for a purchase request. Purchase request include a specific service the third party intend to consume from Payvice, represented by its service code as listed here below:
    </p>
    <p>
      <code> MTNVTU </code> - Request to purchase MTN Airtime <br>
      <code> ETISALTVTU </code> - Request to purchase 9Mobile Aitime <br>
      <code> GLOVTU </code> - Request to purchase Glo Airtime <br>
      <code> AIRTELVTU </code> - Request to purchase Airtel Airtime <br>

    </p>
    <p>
      <code> IE </code> - Request to pay for Ikeja Electricity bill
    </p>

    <p>
      <code> DSTV </code> - Request to subscribe for Multichoice DSTV subscription <br>
      <code> GOTV </code> - Request to subscribe for Multichoice GOTV subscription
    </p>

    <h3 id="subtitle1">HTTP REST REQUEST</h3>
    <p>
      Up to this point you have a clear understanding of consuming Payvice API if you have successfully generated a transaction <code>TOKEN</code>
    </p>
    <p>
      Next, we will proceed with sample request for <code>TOPUP</code> <br>
      Below code is an example of purchasing MTN Virtual Topup - <code>MTNVTU</code>
    </p>

    <pre class="">
      <code class="language-markup">

        {
        "vice_id": "123xxxx", 
        "user_name": "johndoe@payvice.com",
        "amount": "50", 
        "phone": "0810xxxx000", 
        "service": "MTNVTU", 
        "auth": "xxx",
        "token" : "474eef6dca8dd57xxxxxxxxxx******xxxxxxxxxx077834b61f6b1",
        "pwd" : "HiddenSecretxxxx"
      }

      URL:        https://www.payvice.com/api/tran/auth2/purchase
      HTTP VERB:  POST
    </code>
  </pre>
  <p>
    Where: 
  </p>
  <p>
    <code>vice_id</code> - Your Payvice wallet ID <br>
    <code>user_name</code> - Your Payvice usename <br>
    <code>amount</code> - Transaction amount - minimum of 50 <br>
    <code>phone</code> - Phone number to recharge <br>
    <code>service</code> - Request parameter specifying the service to pay for <br>
    <code>auth</code> - Your Payvice 4-digit transaction code <br>
    <code>token</code> - Transaction token gotten from <code>LOOKUP</code> call <br>
    <code>pwd</code> - Your Payvice password
  </p>

  <h3 id="subtitle2">Topup Response</h3>
  <p>
    On successful topup request, below response will be returned 
  </p>
  <pre class="">
    <code class="language-markup">

     {
     "message": "Topup completed successfully",
     "status": 1,
     "date": "30/01/2018 07:27:50",
     "txn_ref": "5a701e76af746"
   }
 </code>
</pre>
<p>
  <code>message</code> - Response message <br>
  <code>status</code> - State of the request where <code>1</code> is Approved or Completed successfully <br>
  <code>date</code> - Response time in <code>dd/mm/YYYY H:i:s</code> format <br>
  <code>txn_ref</code> - Your transaction reference code
</p>



<h3 id="subtitle3">Ikeja Electric Request - <code>IE</code></h3>
<p>
  Just like the <code>TOPUP</code> Request, Payvice has a defined parameters that need to passed for a request to pay for electricity bill for Ikeja Electric covered zone
</p>
<p>
  The first request for <code>IE</code> is to validate customer name existence. This allow you to get confirmation from your 
  customer to determine if payment is going to be made to the right owner.
</p>
<p>
  Sample JSON data below define request parameters for <code>IE</code> name enquiry validation
</p>
<pre class="">
  <code class="language-markup">

   {
   "vice_id": "123xxxxx", 
   "user_name": "johndoe@payvice.com",
   "amount": 10, 
   "phone": "0810xxxx000", 
   "service": "IE", 
   "auth": "xxxx",
   "token" : "474eef6dca8dd57xxxxxxxxxx******xxxxxxxxxx077834b61f6b1",
   "pwd" : "HiddenSecretxxx",
   "cus_meter": "",
   "cus_account": "0100xxxxxx",
   "type": "getcus",
   "service_type": "pay"
 }

 URL:        https://www.payvice.com/api/tran/auth2/purchase
 HTTP VERB:  POST
</code>
</pre>

<p>
  A few things to be noted here: 
</p>
<p>
  <code>service</code> - Always send <code>IE</code> as to indicate Ikeja Electricity transaction <br>
  <code>cus_meter</code> - Contains value of customer number if <code>service_type</code> is vend as to indicate a Token transaction <br>
  <code>type</code> - Remains a static value of <code>getcus</code> to enable validation if customer exists <br>
  <code>cus_account</code> - Contains value of customer account number if <code>service_type</code> is <code>pay</code> as to indicate payment for postpaid customer <br> <br>
  <code>service_type</code> - Should be <code>vend</code> or <code>pay</code> as explained here-above.

</p>



<h3 id="subtitle4">Ikeja Electric Name Enquiry Response</h3>
<p>
  On successful <code>IE</code> name inquiry request, below response will be returned 
</p>
<pre class="">
  <code class="language-markup">

   {
   "message": "Customer name validation was successful",
   "status": 1,
   "date": "13/03/2018 14:52:24",
   "cust_name": "JOHN DOE",
   "cust_address": "01, JUPITER ST, MARS"
 }
</code>
</pre>
<p>
  <code>message</code> - Response message <br>
  <code>status</code> - State of the request where <code>1</code> is Approved or Completed successfully <br>
  <code>date</code> - Response time in <code>dd/mm/YYYY H:i:s</code> format <br>
  <code>txn_ref</code> - Your transaction reference code <br>
  <code>cust_name</code> - The name tied to the account or meter number in Ikeja Electric record <br>
  <code>cust_address</code> - The address tied to the account or meter number in Ikeja Electric record
</p>

<h3 id="subtitle5">Ikeja Electric Purchase Request</h3>
<p>
  Just as the name enquiry validation request, the purchase request will indicate that user has validated and approved the details 
  returned by the validation request [ Name and Address ] and the puprchase request is to purchase the energy.
</p>
<p>
  Still within the lifespan of the <code>TOKEN</code> goten from the lookup request, the below request sample 
  show how to call for purchase.
</p>  
<pre class="">
  <code class="language-markup">

   {
   "vice_id": "123xxxxx", 
   "user_name": "johndoe@payvice.com",
   "amount": 10, 
   "phone": "0810xxxx000", 
   "service": "IE", 
   "auth": "xxxx",
   "token" : "474eef6dca8dd57xxxxxxxxxx******xxxxxxxxxx077834b61f6b1",
   "pwd" : "HiddenSecretxxx",
   "cus_meter": "",
   "cus_account": "0100xxxxxx",
   "type": "getcus",
   "service_type": "pay"
 }

 URL:        https://www.payvice.com/api/tran/auth2/ie/tran
 HTTP VERB:  POST
</code>
</pre>

<p>
  A few things to be noted here: 
</p>
<p>
  <code>service</code> - Always send <code>IE</code> as to indicate Ikeja Electricity transaction <br>
  <code>cus_meter</code> - Contains value of customer number if <code>service_type</code> is vend as to indicate a Token transaction <br>
  <code>type</code> - Remains a static value of <code>getcus</code> to enable validation if customer exists <br>
  <code>cus_account</code> - Contains value of customer account number if <code>service_type</code> is <code>pay</code> as to indicate payment for postpaid customer <br> <br>
  <code>service_type</code> - Should be <code>vend</code> or <code>pay</code> as explained here-above.

</p>
<h3 id="subtitle6">Ikeja Electric Purchase Response</h3>
<p>
  On successful <code>IE</code> purchase request, below response will be returned 
</p>
<p><code>VEND</code> Request Response</p> 
<pre class="">
  <code class="language-markup">

   {
   "message": "Credit purchase was successful",
   "status": 1,
   "date": "13/03/2018 16:15:07",
   "txn_ref": "5aa7f90b3b5dd",
   "token_value": "700xxxxxxxxxxxx24127",
   "address": "7, ROAD NAME STREET, AREA - TOWN DETAILS",
   "payer": "VANESA DOE"
 }
</code>
</pre>

<p><code>PAY</code> Request Response</p> 

<pre class="">
  <code class="language-markup">

    {
    "message": "Completed successfully",
    "status": 1,
    "date": "13/03/2018 16:24:09",
    "txn_ref": "5aa7fb290d97d",
    "address": "7, ROAD NAME STREET, AREA - TOWN DETAILS",
    "payer": "JOHN DOE"
  }
</code>
</pre>

</section>

<section>
    <h2 id="enuguelectricity">Enugu Electricy Integration</h2>
    <p>
      To make successful payment for Enugu Electicity for both prepaid and postpaid , you should always validate customer account/smart card 
      number before making payment. This is to enable you check that payment is being made to the intended party.
    </p> 
  
    <h2 id="validate_enugu">Validate Customer Details</h2>
    <p>
      The sample request below shows how to get validate customers account numbers:
    </p>

    <pre class="">
        <code class="language-markup">
    
            {
              "vice_id": "18xxxxxx3", 
              "user_name": "michxxxxxxxxxda@mail.com",
              "pwd" : "xxxxxxxx",
              "meter": "45037595423",
              "type": "prepaid"
            }
    
              URL:  https://www.payvice.com/api/tran/enugu/lookup
        
              HTTP VERB:  POST    
      </code>
    </pre>
    <p>
      Where: <br>
      <code>vice_id</code> is your Payvice Wallet ID <br>
      <code>user_name</code> is your Payvice username <br>
      <code>pwd</code> is your secure Payvice password <br>
      <code>meter</code> is your electricity account/smartcard number <br>
      <code>type</code> is your current subscription type/package
    </p>

    <p>
      Below response will be returned, on successful lookup:
    </p>
    <pre class="">
      <code class="language-markup">
          {
              "status": 1,
              "error": false,
              "message": "Customer Validation Successful",
              "description": "Customer Validation Successful",
              "name": "Sxxxxxs Nxxxxu",
              "account": "45xxxxxx3",
              "type": "prepaid",
              "productCode": "F04F15047283749C9B7B06146BAFD95E5B373DE36D61ECACEB7C115C7A1B87B6CFCCAEA57A14E202240DDB89B15D7F8471F1194D9F77C2E98217E0097ED70773|eyJwcm9kdWN0IjoiRU5VR1VFTEVDVFJJQ0lUWSIsInR5cGUiOiJwcmVwYWlkIiwiYWNjb3VudCI6IjQ1MDM3NTk1NDIzIiwibmFtZSI6IlNseXZhbnVzIE5nd3UiLCJjdXN0b21lcklkIjoiQWJha3BhfDQ1MDM3NTk1NDIzfDExMTY0OTR8U2x5dmFudXMgTmd3dXxObyAxNTUgTmlrZSBMYWtlIFJvYWQgQWJha3BhIE5pa2UgRW51Z3VfMzAuOTNfUjJTXzAuMCJ9"
          }
      </code>
    </pre>

    <h2 id="validate_pay">Make Enugu Electricity Payment</h2>
    <p>
      The sample request below shows how to make successful payment request for Enugu Electricity.
    </p>
    <pre class="">
        <code class="language-markup">
    
              {
                  "vice_id": "18xxxxxxxx93", 
                  "user_name": "michxxxxxxxxxxxa@mail.com",
                  "pwd" : "xxxxxxxxxxxxxxxxxx",
                  "meter": "45037595423",
                  "type": "prepaid",
                  "amount": 100,
                  "phone": "081xxxxxxxxxx323",
                  "code": "F04F15047283749C9B7B06xxxxxxxxxxxxxxxxxx",
                  "name": "Slyvanus Ngwu",
                  "token": "7cef91d8ea5da1f2a1xxxxxxxxxxxxxxxxxxc5a3640b52113a5756f",
                  "auth": "XXXX"
              }
              URL: https://www.payvice.com/api/tran/auth2/enugu/pay
        
              HTTP VERB:  POST    
      </code>
    </pre>
    <p>
        Where: <br>
        <code>vice_id</code> is your Payvice Wallet ID <br>
        <code>user_name</code> is your Payvice username <br>
        <code>pwd</code> is your secure Payvice password <br>
        <code>meter</code> is your electricity account/smartcard number <br>
        <code>type</code> is your current subscription type/package<br>
        <code>code</code> is the product code returned during previous lookup<br>
        <code>name</code> is the name of the customer returned during lookup
    </p>
    {{-- <p>
        Below response will be returned, on successful lookup:
    </p> --}}
</section>

<section>
  <h2 id="multichoice">Making Multichoice Payment</h2>
  <p>
    To make payment for Multichoice <code>DSTV</code> or <code>GOTV</code>, there are few important steps to 
    consider for a secure and safe payment. By safe we mean always consider to validate customer account/smart card 
    number before making payment. This is to enable you check that payment is being made to the intended party.
  </p> 
  <p>
    Payvice also gives you the ability to select or make your users select from various subscription plans available 
    for Multichoice <code>DSTV</code> or <code>GOTV</code>
  </p> 

  <h2 id="plans">Get Subscription Plans</h2>
  <p>
    The sample request below shows how to get subscription plans:
  </p>
  <pre class="">
    <code class="language-markup">

      { 

      "vice_id": "1234xxxxx",
      "user_name": "johndoe@payvice.com",
      "service": "DSTV", 
      "beneficiary": "1017xxxxx"

    }

    URL:        https://www.payvice.com/api/tran/auth2/bill/tv
    
    HTTP VERB:  POST


  </code>
</pre>
<p>
  Where: <br>
  <code>vice_id</code> is your Payvice Wallet ID <br>
  <code>user_name</code> is your Payvice username <br>
  <code>service</code> indicate Multichoice service - DSTV or GOTV <br>
  <code>beneficiary</code> DSTV or GOTV smart card/account number
</p>

<p>
  Below response will be returned, on successful request:
</p>
<pre class="">
  <code class="language-markup">

    {


    "message": "Subscription plans lookup was successful",
    "status": 1,
    "date": "18/04/2018 15:34:59",
    "plans": [
    {
    "name": "Active Package",
    "product_code": "AP",
    "amount": "1900.00"
  },
  {
  "name": "DStv French Touch",
  "product_code": "FRN7E36",
  "amount": "1400.00"
},
{
  "name": "DStv Great Wall",
  "product_code": "GWALLE36",
  "amount": "1000.00"
},
{
  "name": "DStv Indian",
  "product_code": "ASIAE36",
  "amount": "4800.00"
},
{
  "name": "DStv Compact",
  "product_code": "COMPE36",
  "amount": "6300.00"
},
{
  "name": "DStv Compact Plus",
  "product_code": "COMPLE36",
  "amount": "9900.00"
},
{
  "name": "DStv Family",
  "product_code": "COFAME36",
  "amount": "3800.00"
},
{
  "name": "DStv Premium",
  "product_code": "PRWE36",
  "amount": "14700.00"
}
]


}

</code>
</pre>

<h2 id="account">Validate Customer Account</h2>
<p>
  Below sample request will validate customer account or smart card number:
</p>
<pre class="">
  <code class="language-markup">

    { 

    "vice_id": "1234xxxxx",
    "user_name": "johndoe@payvice.com",
    "service": "DSTV", 
    "beneficiary": "10173xxxxxx"

  }

  URL:        https://www.payvice.com/api/tran/auth2/bill/validate

  HTTP VERB:  POST


</code>
</pre>

<p>
  Below response will be returned when validation is successful
</p>

<pre class="">
  <code class="language-markup">

    {
    "message": "Account validation was successful",
    "status": 1,
    "date": "18/04/2018 13:44:29",

    "customer": {

    "tran_id": "1924xxxx",
    "ref": "1183846xxxxxx",
    "response_code": "00",
    "fullname": "JOHN DOE",
    "unit": "DSTV"
  }


}

</code>
</pre>

<h2 id="pay">Making DSTV/GOTV Payment</h2>

<p>
  When you have successfully validated the first two requests, the already-defined Payvice process of performing 
  transaction remain the same. For the fact that your transaction <code>TOKEN</code> has a lifespan, we would advise you 
  perform the 2 Multichoice calls before generating transaction token.
</p>   

<p>
  The sample code here shows how to make payment
</p> 

<pre class="">
  <code class="language-markup">

    { 

    "vice_id": "1234xxxxx",
    "user_name": "johndoe@payvice.com",
    "auth": "xxxx",
    "token" : "474eef6dca8dd57xxxxxxxxxx******xxxxxxxxxx077834b61f6b1",
    "pwd" : "HiddenSecretxxx"
    "phone": "080873xxxxxx", 
    "service": "DSTV",
    "beneficiary": "10173xxxxx",
    "product_code": "AP"

  }

  URL:        https://www.payvice.com/api/tran/auth2/tv/pay

  HTTP VERB:  POST


</code>
</pre>

<p>
  On a successful subscription request, the following response will be returned
</p>

<pre class="">
  <code class="language-markup">

    {

    "message": "DSTV - Subscription was successful",
    "status": 1,
    "date": "18/04/2018 15:17:39",
    "txn_ref": "5ad761935c7ee"

  }

</code>
</pre>

<h2>DSTV/GOTV Test</h2>
<p>
  To test Multichoice transaction call the following endpoints:
</p>
<pre class="">
  <code class="language-markup">

    https://www.payvice.com/api/tran/auth2/bill/tv/test

    https://www.payvice.com/api/tran/auth2/bill/validate/test

    https://www.payvice.com/api/tran/auth2/tv/pay/test

  </code>
</pre>
</section>  

<section>
  <h2 id="transfer">Wallet to Wallet Transfer</h2>
  <p>
    Another advantage of Payvice is to enable users/third party application to do a wallet-to-wallet transfer
  </p>
  <p>
    This request will enable you transfer fund from one wallet to another <code>Wallet ID</code> <br>
    The parameters accepted in the request are shown in the sample request below:
  </p>
  <pre class="">
    <code class="language-markup">

      { 

      "vice_id": "1234xxxxx",
      "user_name": "johndoe@payvice.com",
      "amount": 50,
      "beneficiary": "4567xxxx",
      "auth": "xxxx",
      "token" : "474eef6dca8dd57xxxxxxxxxx******xxxxxxxxxx077834b61f6b1",
      "pwd" : "HiddenSecretxxx"

    }

    URL:        https://www.payvice.com/api/tran/auth2/wallet/transfer
    
    HTTP VERB:  POST


  </code>
</pre>

<p>
  Where <code>TOKEN</code> is your generated token on <code>LOOKUP</code> request <br>
  <code>beneficiary</code> is the wallet to transfer fund to <br>
  <code>amount</code> minimum of N50
</p>
<p>TRANSFER Request Response</p> 
<pre class="">
  <code class="language-markup">

    {

    "message": "Fund transfered successfully",
    "status": 1,
    "date": "06/04/2018 16:02:50",
    "txn_ref": "5ac79a2a2af29"

  }

</code>
</pre>
</section>

<section>
  <h2 id="title2">Possible Error Messages</h2>
  <p>
    Yes, it is possible to encounter some errors :) <br>
    As you can also imagine, like what happens when there's a missing parameter, invalid username, incorrect account number for <code>IE</code> <br>
    Below are some possible errors message that might be returned when consuming our API
  </p>
  <p>
   When one of the combination of the following parameters is wrong or all values are worng: <code>Wallet ID</code>, <code>Username</code>, <code>Password</code>, <code>Transaction PIN</code>
 </p>
 <pre class="">
  <code class="language-markup">

   {
   "status": 0,
   "message": "Unknown user ID or wrong password"
 }

</code>
</pre>

<p>
 When the generated <code>TOKEN</code> as exceeded 2 minutes of its lifespan   
</p>
<pre class="">
  <code class="language-markup">

   {
   "status": 0,
   "message": "Unauthorized API call. Token expired"
 }

</code>
</pre>

<p>
  When the request <code>TOKEN</code> or <code>Wallet ID</code> is invalid
</p>
<pre class="">
  <code class="language-markup">

    {
    "status": 0,
    "message": "Failed. Please check your token/Vice ID"
  }

</code>
</pre>

<p>
  When the same <code>TOKEN</code> is sent 2 times within 2 minutes of its lifespan
</p>
<pre class="">
  <code class="language-markup">

   {
   "status": 0,
   "message": "Unauthorized API call. Token already used"
 }

</code>
</pre>

<p>
  When the <code>CUSMTOMER METER</code> or <code>ACCOUNT NUMBER</code> for Ikeja Electric provided is not valid 
</p>
<pre class="">
  <code class="language-markup">

    {
    "message": "Lookup failed. Customer information not found",
    "status": 0,
    "date": "30/01/2018 08:24:00"
  }

</code>
</pre>


<p>
 When the Wallet to <code>TRANSFER</code> to does not exist  
</p>
<pre class="">
  <code class="language-markup">

    {

    "message": "Unknown Recipient wallet",
    "status": 0,
    "date": "06/04/2018 16:27:33",
    "txn_ref": "5ac79ff51dd14"

  }

</code>
</pre>

</section>


<section>
  <h2 id="requery">Checking Previous Transaction</h2>
  <p>
    Sometime you might decide to check the status of previously generated token or transaction.
  </p>
  <p>
    The sample call below demonstrate how you can achieve the <code>REQUERY</code> call
  </p>
  <pre class="">
    <code class="language-markup">

      {
      "vice_id": "123xxxxx", 
      "token": "474eef6dca8dd57xxxxxxxxxx******xxxxxxxxxx077834b61f6b1"
    }

    URL:         https://www.payvice.com/api/tran/auth0/requery
    HTTP VERB:   POST

  </code>

</pre>
<p>
  where:
</p>
<p>
  <code>vice_id</code> - Your Payvice wallet ID <br>
  <code>token</code> - Transaction token
</p>
<h2 id="requery">Requery Response</h2>
<p>
  Below response will be returned:
</p>

<pre class="">
  <code class="language-markup">

    {
    "status": 1,
    "txn_status": "declined",
    "txn_date": "13/11/2017 08:08:48",
    "vice_id": "123xxxxx",
    "txn_token": "474eef6dca8dd57xxxxxxxxxx******xxxxxxxxxx077834b61f6b1",
    "date": "01/02/2018 07:15:09"
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
        <p>Copyright &copy; {{ date('Y') }} ITEX Integrated Services. All right reserved</p>
      </div>
      <div class="col-md-6 col-sm-6">
        <ul class="footer-menu">
          <li><a href="http://www.iisysgroup.com">Know ITEX</a></li>
          <li><a href="mailto:info@iissygroup.com">Drop a message</a></li>
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
