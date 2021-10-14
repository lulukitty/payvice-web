<div id="pinEntry" class="panel panel-default" style = "display:none;">
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

@section('pinEntryScripts')
<script type = "text/javascript">

	function showPinEntry(){

		document.getElementById('pinEntry').style.display = "block";
	}

</script>
@show
@endsection