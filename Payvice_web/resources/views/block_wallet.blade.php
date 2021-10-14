<?php

//////WE HAVE COMMENTED OUT THE PHP & JQUERY PARTS BECAUSE WE ARE GETTING ERRORS.
/////PERHAPS BECAUSE NO ENDPOINT YET.
/////PLEASE GO THROUGH IT TO STUDY THE LOGIC.

session_start(); //Start session at the beginning of your script  

//Retrieve AJAX data
// $wallet_id = $_POST['w']; 
// $pin = $_POST['p'];

//This part depends on database (& endpoints)
// $sql=$db->prepare("SELECT * FROM user data WHERE   wallet_id=:wallet_id AND pin=:pin");
// $sql->bindParam(':wallet_id',$wallet_id);
// $sql->bindParam(':pin',$pin);
// $sql->execute();

//Fetch Single Result with pdo, use php function count to see if you have found something
// if( $sql->fetch() ){ 
//     $_SESSION['account']=true;
//     $data['state'] = 1; 
// }
// else{
//     $data['state'] = 0;  
// }

// header("Content-type: application/json; charset=utf-8");
// echo json_encode($data); 

?>

@extends('layouts.master')
@section('content')
<div id="wrapper" class="toggled">
<div role="navigation" class="wrap-body" id="sidebar-wrapper">
@include('layouts.menu')
<div class="p-20" id="page-content-wrapper">
      <section>
  @include('layouts.sub-menu')
	<div class="row mt-100">
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
	<div class="row no-margin">
<div class="col-lg-7 col-lg-offset-2 col-md-offset-1 col-sm-offset-2 col-md-9 col-sm-12 col-xs-12">
    <div class="panel-footer no-bg no-bd">
     <div class="row">
<div class="col-lg-12">
	<div class="single category">

<div id="wrapper" class="container">

    <div class="col-md-8" style="margin-top: 2">

    <form action="#" method="post" id="form1" style="width: 70%">

    <h3>Block Wallet</h3>
    <h5 style="padding-bottom: 20px">Enter your details below to block your Payvice wallet</h5>
        
        <div class=" form-group">
            <input class="form-control" type="text" id="wallet_id" name="wallet_id" placeholder="Wallet ID" required />
        </div>

        <div class=" form-group">
            <input class="form-control" type="password" id="pin" name="pin" placeholder="Enter your 4 digit transaction pin" required maxlength="4" />
        </div>

        <div class="form-group" style="padding-top: 10px">
            <br/>
            <button type="submit" form="form1" value="Submit" id="submit" class="btn btn-info">Proceed</button>
        </div>
    </form>
    </div>
    <div class="col-md-2"></div>
</div>
</div>
@include('layouts.side-adv')
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

<!-- <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>

<script type="text/javascript">

 // function that waits for the DOM to be ready
 $(function() {
    var wallet_id = $('#wallet_id').val(),
       pin = $('#pin').val(),
       submit = $('#submit');

        //Capture the submit button click & prevent form to be sent
       submit.on('click', function(e){
        e.preventDefault();

              //perform Ajax POST
                $.post( "/path/to/your/php code", //not sure about this 
                    // {w: wallet_id, p: pin},
                    function( data ) { 

                      //In case of success, data will return what is defined in php script 
                      //to trigger your swal notification
                      if(data.state == 1) {
                         swal({
                            title: "Are you sure you want to proceed to block your wallet?"
                            text: "This action cannot be undone."
                            icon: "warning",
                            buttons: {
                                cancel: "Close", //button takes back to wallet block form
                                proceed: "Yes"
                            }
                            dangerMode: true,
                                 })

                            .then((willBlock) => {
                            if (willBlock) {
                             swal({
                                 title: "Your Payvice wallet has been successfully blocked." 
                                 text: "Please visit any ITEX ffice near you to unblock it.",
                                icon: "success",
                                 });
                                 } 
                            });
                         //redirect here
                         window.location.href = "http://example.com/account/";
                      }
                      else
                         swal("Credentials don't match. Check your details and try again.", "error");
                    });
              });});

 
</script> -->
