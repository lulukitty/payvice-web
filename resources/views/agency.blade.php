<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="keywords" content="">

  <title>UBA Agency Banking  - API Documentation</title>

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
     
      <li>
        <a href="#title1">UBA Agency Banking APIs</a>
        <ul>
         
          <li><a href="#html-structure">Balance Lookup</a></li>
          <li><a href="#variations">Lookup Response</a></li>

          <li><a href="#html-structure">Account Opening Request</a></li>
          <li><a href="#variations">Lookup Response</a></li>

          <li><a href="#html-structure">Cash IN Request</a></li>
          <li><a href="#variations">Lookup Response</a></li>

          <li><a href="#html-structure">Cash OUt Request</a></li>
          <li><a href="#variations">Lookup Response</a></li>

          <li><a href="#html-structure">Transfer Request</a></li>
          <li><a href="#variations">Lookup Response</a></li>


          <li><a href="#html-structure">Token Gen</a></li>
          <li><a href="#variations">Lookup Response</a></li>

          <li><a href="#html-structure">Token Auth Lookup</a></li>
          <li><a href="#variations">Lookup Response</a></li>
          <li><a href="#subtitle3">Subtitle 3</a></li>
          <li><a href="#subtitle4">Subtitle 4</a></li>
        </ul>
      </li>
      <li><a href="#title2">Second Title</a></li>
    </ul>

  </aside>
  <!-- END Sidebar -->


  <header class="site-header navbar-transparent">

    <!-- Banner -->
    <div class="banner auto-size" style="background-color: #5cc7b2">
      <div class="container-fluid text-white">
        <h1><strong>UBA Agency BAnking  - </strong> VAS API implementation</h1>
        <h5>A Guide for Developers</h5>
      </div>
    </div>
    <!-- END Banner -->

  </header>

  <main class="container-fluid">

    <!-- Main content -->
    <article class="main-content" role="main">

      <p class="lead">

        UBA Agency Banking offers various Value Added Services (VAS), ranging from Airtime purchase, Bill payment, Toll Gate fee, Internet subscription to Cable TV. The lines below serve as a guidance to third party application willing to consume UBA Agency Banking services over HTTP REST API or other protocol supported.
      </p>

      <section>
        <h2 id="html-structure">Consumming the API</h2>
        <p>While this page is enough to see through its code and get you started with, you will need to signup to UBA to get your wallet ID and login credentials. Sure you would have obtained your UBA Agency Banking credentials <code>Wallet ID</code>, <code>Username</code> and <code>Password</code>.</p>



        <h2>HTTP POST Request - REST</h2>
        <p>
          To consume UBA Agency Banking API, the follwing two steps are required:
          <code>LOOKUP</code> call and <code>PURCHASE</code> for the topup
        </p>
        

      </section>


      


      <section>
        <h2 id="title1">Balance Request Parameters</h2>
        <p>
          After a successful <code> LOOKUP </code> request, as earlier stated - within the two-minute lifespan of your token, the sample code below demonstrate how to call for a purchase request. Purchase request include a specific service the third party intend to consume from UBA Agency Banking, represented by its service code as listed here below:
        </p>
        <p>
          <code> AGENTID </code> - Agent ID for this request <br>
          <code> ACCOUNT NUMBER </code> - Customer Account Number  <br>
          <code> APITOKEN </code> - Agent Api Token for this request <br>
          <code> AuthorisedID </code> -  Agent Authorised ID for this request <br>

        </p>
        <p>
          <code> Service </code> - Request for the API [BALANCEINFOR]
        </p>

        <pre class="">
          <code class="language-markup">

            &lt;root&gt;
            &lt;Tid&gt;12345678&lt;/Tid&gt;
            &lt;Service&gt;AGENTKYC&lt;/Service&gt;
            &lt;ACCOUNTNUMBER&gt;123456789&lt;/ACCOUNTNUMBER&gt; 
            &lt;AGENTID&gt;12345&lt;/AGENTID&gt;
            &lt;APIID&gt;123454&lt;/APIID&gt;
            &lt;AuthorisedID&gt;123456789&lt;/AuthorisedID&gt;
            &lt;/root&gt;

            URL:        http://localhost/tams/tams/agentcy_banking_api.php
            HTTP VERB:  POST
          </code>
        </pre>


        <h2 id="title1">Balance Response</h2>
        <pre class="">
          <code class="language-markup">

            &lt;soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"&gt;&lt;soap:Body&gt;
            &lt;ns1:sendTransactionResponse xmlns:ns1="http://finaclews.org"&gt;

            &lt;return&gt;&lt;![CDATA[&lt;?xml version="1.0" encoding="UTF-
            8"?&gt;&lt;C24TRANRES&gt;&lt;ACTION_CODE&gt;000&lt;/ACTION_CODE&gt;&lt;STAN&gt;1768015&lt;/STAN&gt;&lt;TRAN_DATE_TIME&gt;20151113173658

            &lt;/TRAN_DATE_TIME&gt;&lt;AVAILABLE_BALANCE&gt;+0000000000213256&lt;/AVAILABLE_BALANCE&gt;&lt;LEDGER_BALANCE&gt;+000000
            0000213256&lt;/LEDGER_BALANCE&gt;&lt;BALANCE_CURRENCY&gt;NGN&lt;/BALANCE_CURRENCY&gt;&lt;COUNTRY_CODE&gt;NGA&lt;/COUN
            TRY_CODE&gt;&lt;ACCOUNT_INFO&gt;&lt;ACCT_NAME&gt;UGWU,
            JUACHUKWU&lt;/ACCT_NAME&gt;&lt;SCHM_TYPE&gt;ODA&lt;/SCHM_TYPE&gt;&lt;ACCT_STATUS&gt;A&lt;/ACCT_STATUS&gt;&lt;ACCT_SOL_ID&gt;099
            9&lt;/ACCT_SOL_ID&gt;&lt;SCHM_CODE&gt;CASTF&lt;/SCHM_CODE&gt;&lt;GL_SUB_HEAD&gt;21008&lt;/GL_SUB_HEAD&gt;&lt;LIEN_AMT&gt;+0000000
            000000000&lt;/LIEN_AMT&gt;&lt;/ACCOUNT_INFO&gt;&lt;CUSTOMER_INFO&gt;&lt;CUST_ID&gt;003403757
            &lt;/CUST_ID&gt;&lt;CUST_NAME&gt;JUACHUKWU C UGWU
            &lt;/CUST_NAME&gt;&lt;PHONENO&gt;2348036636027&lt;/PHONENO&gt;&lt;EMAIL&gt;&lt;/EMAIL&gt;&lt;/CUSTOMER_INFO&gt;&lt;/C24TRANRES&gt;]]&gt;&lt;/retur
            n&gt;
            &lt;/ns1:sendTransactionResponse&gt;
            &lt;/soap:Body&gt;
            &lt;/soap:Envelope&gt;

            
          </code>
        </pre>





        <h2 id="title1">Pan to Account  Request Parameters</h2>
        <p>
          After a successful <code> LOOKUP </code> request, as earlier stated - within the two-minute lifespan of your token, the sample code below demonstrate how to call for a purchase request. Purchase request include a specific service the third party intend to consume from UBA Agency Banking, represented by its service code as listed here below:
        </p>
        <p>
          <code> AGENTID </code> - Agent ID for this request <br>
          <code> PAN NUMBER </code> - Customer PAN Number  <br>
          <code> APITOKEN </code> - Agent Api Token for this request <br>
          <code> AuthorisedID </code> -  Agent Authorised ID for this request <br>

        </p>
        <p>
          <code> Service </code> - Request for the API [PAN]
        </p>

        <pre class="">
          <code class="language-markup">

            &lt;root&gt;
            &lt;Tid&gt;12345678&lt;/Tid&gt;
            &lt;Service&gt;PAN&lt;/Service&gt;
            &lt;PANNUMBER&gt;123456789&lt;/PANNUMBER&gt; 
            &lt;AGENTID&gt;12345&lt;/AGENTID&gt;
            &lt;APIID&gt;123454&lt;/APIID&gt;
            &lt;AuthorisedID&gt;123456789&lt;/AuthorisedID&gt;
            &lt;/root>

            URL:        http://localhost/tams/tams/agentcy_banking_api.php
            HTTP VERB:  POST
          </code>
        </pre>


        <h2 id="title1">PAN Response</h2>
        <pre class="">
          <code class="language-markup">

           {["PAN":"","ACCOUNTNUMBER":"1234567890"]}

           
         </code>
       </pre>





       <h2 id="title1">Generate Token  Request Parameters</h2>
       <p>
        After a successful <code> LOOKUP </code> request, as earlier stated - within the two-minute lifespan of your token, the sample code below demonstrate how to call for a purchase request. Purchase request include a specific service the third party intend to consume from UBA Agency Banking, represented by its service code as listed here below:
      </p>
      <p>
        <code> AGENTID </code> - Agent ID for this request <br>
        <code> USERID </code> - Customer USERID Number  <br>
        <code> APITOKEN </code> - Agent Api Token for this request <br>
        <code> AuthorisedID </code> -  Agent Authorised ID for this request <br>

      </p>
      <p>
        <code> Service </code> - Request for the API [TOKENGEN]
      </p>

      <pre class="">
        <code class="language-markup">

          &lt;root&gt;
          &lt;Tid&gt;12345678&lt;/Tid&gt;
          &lt;Service&gt;GENTOKEN&lt;/Service&gt;
          &lt;USERID&gt;123456789&lt;/USERID&gt; 
          &lt;AGENTID&gt;12345&lt;/AGENTID&gt;
          &lt;APIID&gt;123454&lt;/APIID&gt;
          &lt;AuthorisedID&gt;123456789&lt;/AuthorisedID&gt;
          &lt;/root>

          URL:        http://localhost/tams/tams/agentcy_banking_api.php
          HTTP VERB:  POST
        </code>
      </pre>










      <h2 id="title1">Generate Token  Response</h2>
      <pre class="">
        <code class="language-markup">

         {["TOKEN":"1111111111234511111111"]}
         
       </code>
     </pre>








     <h2 id="title1">Auth Token  Request Parameters</h2>
     <p>
      After a successful <code> LOOKUP </code> request, as earlier stated - within the two-minute lifespan of your token, the sample code below demonstrate how to call for a purchase request. Purchase request include a specific service the third party intend to consume from UBA Agency Banking, represented by its service code as listed here below:
    </p>
    <p>
      <code> AGENTID </code> - Agent ID for this request <br>
      <code> TOKEN NUMBER </code> - Customer PAN Number  <br>
      <code> APITOKEN </code> - Agent Api Token for this request <br>
      <code> AuthorisedID </code> -  Agent Authorised ID for this request <br>

    </p>
    <p>
      <code> Service </code> - Request for the API [TOKENAUTH]
    </p>

    <pre class="">
      <code class="language-markup">

        &lt;root&gt;
        &lt;Tid&gt;12345678&lt;/Tid&gt;
        &lt;Service&gt;AGENTKYC&lt;/Service&gt;
        &lt;TOKENNUMBER&gt;123456789&lt;/TOKENNUMBER&gt; 
        &lt;AGENTID&gt;12345&lt;/AGENTID&gt;
        &lt;APIID&gt;123454&lt;/APIID&gt;
        &lt;AuthorisedID&gt;123456789&lt;/AuthorisedID&gt;
        &lt;/root>

        URL:        http://localhost/tams/tams/agentcy_banking_api.php
        HTTP VERB:  POST
      </code>
    </pre>




    <h2 id="title1">Generate Auth  Response</h2>
    <pre class="">
      <code class="language-markup">

       {["Auth":"Approved"]}
       
     </code>
   </pre>





   <h2 id="title1">Cash In  Request Parameters</h2>
   <p>
    After a successful <code> LOOKUP </code> request, as earlier stated - within the two-minute lifespan of your token, the sample code below demonstrate how to call for a purchase request. Purchase request include a specific service the third party intend to consume from UBA Agency Banking, represented by its service code as listed here below:
  </p>
  <p>
    <code> AGENTID </code> - Agent ID for this request <br>
    <code> ACCOUNT NUMBER </code> - Customer Account Number  <br>

    <code> AMOUNT NUMBER </code> - Amount   <br>
    <code> BANK  </code> - Customer Bank  <br>

    <code> APITOKEN </code> - Agent Api Token for this request <br>
    <code> AuthorisedID </code> -  Agent Authorised ID for this request <br>

  </p>
  <p>
    <code> Service </code> - Request for the API [CASHIN]
  </p>

  <pre class="">
    <code class="language-markup">

      &lt;root&gt;
      &lt;Tid&gt;12345678&lt;/Tid&gt;
      &lt;Service&gt;CASHIN&lt;/Service&gt;
      &lt;ACCOUNTNUMBER&gt;123456789&lt;/ACCOUNTNUMBER&gt; 
      &lt;AMOUNT&gt;12345&lt;/AMOUNT&gt;
      &lt;BANK&gt;12345&lt;/BANK&gt;
      &lt;APIID&gt;123454&lt;/APIID&gt;
      &lt;AuthorisedID&gt;123456789&lt;/AuthorisedID&gt;
      &lt;/root>

      URL:        http://localhost/tams/tams/agentcy_banking_api.php
      HTTP VERB:  POST
    </code>
  </pre>








  <h2 id="title1">Cash In Response</h2>
  <pre class="">
    <code class="language-markup">
     {["Result":"1","MEssage":"Approved"]}
   </code>
 </pre>






 <h2 id="title1">Cash Out  Request Parameters</h2>
 <p>
  After a successful <code> LOOKUP </code> request, as earlier stated - within the two-minute lifespan of your token, the sample code below demonstrate how to call for a purchase request. Purchase request include a specific service the third party intend to consume from UBA Agency Banking, represented by its service code as listed here below:
</p>
<p>
  <code> AGENTID </code> - Agent ID for this request <br>
  <code> ACCOUNT NUMBER </code> - Customer Account Number  <br>

  <code> AMOUNT NUMBER </code> - Amount   <br>
  <code> BANK  </code> - Customer Bank  <br>

  <code> APITOKEN </code> - Agent Api Token for this request <br>
  <code> AuthorisedID </code> -  Agent Authorised ID for this request <br>

</p>
<p>
  <code> Service </code> - Request for the API [CASHOUT]
</p>

<pre class="">
  <code class="language-markup">

   &lt;root&gt;
   &lt;Tid&gt;12345678&lt;/Tid&gt;
   &lt;Service&gt;CASHOUT&lt;/Service&gt;
   &lt;ACCOUNTNUMBER&gt;123456789&lt;/ACCOUNTNUMBER&gt; 
   &lt;AMOUNT&gt;12345&lt;/AMOUNT&gt;
   &lt;BANK&gt;12345&lt;/BANK&gt;
   &lt;APIID&gt;123454&lt;/APIID&gt;
   &lt;AuthorisedID&gt;123456789&lt;/AuthorisedID&gt;
   &lt;/root>

   URL:        http://localhost/tams/tams/agentcy_banking_api.php
   HTTP VERB:  POST
 </code>
</pre>



<h2 id="title1">Cash Out Response</h2>
<pre class="">
  <code class="language-markup">
   {["Result":"1","MEssage":"Approved"]}
 </code>
</pre>












<h2 id="title1">Transfer  Request Parameters</h2>
<p>
  After a successful <code> LOOKUP </code> request, as earlier stated - within the two-minute lifespan of your token, the sample code below demonstrate how to call for a purchase request. Purchase request include a specific service the third party intend to consume from UBA Agency Banking, represented by its service code as listed here below:
</p>
<p>
  <code> AGENTID </code> - Agent ID for this request <br>
  <code> ACCOUNT NUMBER </code> - Customer Account Number  <br>

  <code> AMOUNT NUMBER </code> - Amount   <br>
  <code> BANK  </code> - Customer Bank  <br>


  <code>DR ACCOUNT NUMBER </code> - Customer Account Number  <br>

  <code>DR AMOUNT NUMBER </code> - Amount   <br>
  <code>DR BANK  </code> - Customer Bank  <br>


  <code> APITOKEN </code> - Agent Api Token for this request <br>
  <code> AuthorisedID </code> -  Agent Authorised ID for this request <br>

</p>
<p>
  <code> Service </code> - Request for the API [TRANSFER]
</p>

<pre class="">
  <code class="language-markup">
   &lt;root&gt;
   &lt;Tid&gt;12345678&lt;/Tid&gt;
   &lt;Service&gt;CASHOUT&lt;/Service&gt;
   &lt;ACCOUNTNUMBER&gt;123456789&lt;/ACCOUNTNUMBER&gt; 
   &lt;AMOUNT&gt;12345&lt;/AMOUNT&gt;
   &lt;BANK&gt;12345&lt;/BANK&gt;
   &lt;CRACCOUNTNUMBER&gt;123456789&lt;/CRACCOUNTNUMBER&gt; 
   &lt;CRAMOUNT&gt;12345&lt;/CRAMOUNT&gt;
   &lt;CRBANK&gt;12345&lt;/CRBANK&gt;
   &lt;APIID&gt;123454&lt;/APIID&gt;
   &lt;AuthorisedID&gt;123456789&lt;/AuthorisedID&gt;
   &lt;/root>

   URL:        http://localhost/tams/tams/agentcy_banking_api.php
   HTTP VERB:  POST
 </code>
</pre>


<h2 id="title1">Transfer  Response</h2>
<pre class="">
  <code class="language-markup">
   {["Result":"1","MEssage":"Approved"]}
 </code>
</pre>


</article>
<!-- END Main content -->
</main>


<!-- Footer -->
<footer class="site-footer">
  <div class="container-fluid">
    <a id="scroll-up" href="#"><i class="fa fa-angle-up"></i></a>

    <div class="row">
      <div class="col-md-6 col-sm-6">
        <p>Copyright &copy; 2017. All right reserved</p>
      </div>
      <div class="col-md-6 col-sm-6">
        <ul class="footer-menu">
          <li><a href="page_changelog.html">Changelog</a></li>
          <li><a href="page_credits.html">Credits</a></li>
          <li><a href="mailto:support@thetheme.io">Contact us</a></li>
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
