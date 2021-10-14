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
	<div class="row no-margin">
<div class="col-lg-7 col-lg-offset-2 col-md-offset-1 col-sm-offset-2 col-md-9 col-sm-12 col-xs-12 padded-area">

<div id="commissionTransferSection">
											
													<div id="dashboard">
														<div id="commissionAmount">
														<div class="col-md-12 col-sm-12 payProcess"></div>
																	<div class = "col-lg-12">
																		<h4> Transfer Commision</h4>
																		<p class="small mb-50"> Move funds from your commission to your wallet </p>
																	</div>
																	<form id = "commissionStepOneForm">
																		<div class=" form-group">
																				<div>
																					<span class="fstylec">&#8358;</span>
																				</div>
																				<input placeholder="Enter Amount" class="form-control" type="text" required name="amount">
																		</div>
																		<br>
																		<div class="form-group">
																			<button type="submit" id="commissionStepOne" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
																				PROCEED
																			<span class="arrow"></span>
																		</button>
																	</div>
																</form>

													
											
												</div>
													<div id="pinEntry" class="panel panel-default" style = "display:none;">
														<div class="panel-body text-center">
															<div class="authimg">
																<img style="margin: 20px auto;" src="{{ URL::asset('assets/img/password.svg') }}">
															</div>
															<h4>Your 4 Digit PIN</h4>
															<P class="medium">This is your personal digit PIN needed to complete this transaction</P>
														</div>
														<div class="no-bd">
															<div class=" form-group">
																<input type="text" style="margin:0px auto" class="pincode-input5"  name="pin" >
															</div>
															<br>
															<div class="form-group p-20">
																<button id="pinProceed" type = "submit" class="btn-customb btn-block arrow-btn waves-effect waves-classic">
																	<span class="payBtn">PROCEED</span>
																<span class="arrow"></span>
															</button>
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
</section>
<div>	

	@section("commissionTransferScripts")
	<script type = "text/javascript">

		$(document).ready(function(){

			var proceeding = false;

			$("#commissionTransferSection #commissionStepOneForm").on("submit", function(e){
				e.preventDefault();
				$("#pinEntry").show("slide");
				$("#commissionAmount").hide();
				//alert("Hello");
			})


			$("#pinProceed").on("click", function(e){
				e.preventDefault();

				if(proceeding){
					return false;
				}

				proceeding = true;

				var pinPad = $('#pinEntry').html();

				$('#pinProceed').html('<i class="fa fa-spin fa-spinner"></i> PROCESSING...');
				//$('#pinProceed').disable();

				$.ajax({
				  url: '/transfer-commission',
				  type: 'POST',
				  dataType: 'json',
				  data: {
				    amount: $('input[name=amount]').val(),
				    pin:   $('input[name=pin]').val()
				  },
				  success: function(result){

				  	//$('#pinEntry').html(pinPad);
				  	proceeding = false;

				    if (result['status'] === 1) {
				     swal('Commission Transfer', result['message'], 'success');
				     location.reload();
				    } else {

				    	swal('Commission Transfer', result['message'], 'error');

				    	$("#pinEntry").hide();
				    	$("#commissionAmount").show();

				    }
				  },
				  error: function(){

				  	//$('#pinEntry').html(pinPad);
				  	proceeding = false;


				  	swal('Commission Transfer', "Error Occured", 'error');

				  	$("#pinEntry").hide();
				  	$("#commissionAmount").show();

				  	//location.reload();
				  }

				});

				//$("#commissionAmount").hide();
				//$("#pinEntry").show();
				//alert("Hello");
			})




		});

	</script>
	@endsection









</div>
</div>
@stop