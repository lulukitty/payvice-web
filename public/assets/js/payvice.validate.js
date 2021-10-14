var UINotific8 = function (heading, message, theme) {
	var settings = {
		theme: theme,
		horizontalEdge: 'top',
		verticalEdge: 'right',
		life: '5000',
		heading: $.trim(heading)
	}

	$.notific8('zindex', 11500);
	$.notific8($.trim(message), settings);

};


$(document).on('click', '#verifyRef', function(event) {
	event.preventDefault();
	if ($('input[name=super]').val() == "") {
		UINotific8('Referral code', "Referral code must not be empty", 'ruby');
	}else if ($('input[name=super]').val().length < 8){
		UINotific8('Referral code', "Referral code must exactly 8 digits", 'ruby');
	}else{
		$('#verifyRef').html('<i class="fa fa-spin fa-spinner"></i> VERIFYING...');

		$.ajax({
			url: '/vice/verify/ref',
			type: 'POST',
			dataType: 'json',
			data: {code: $('input[name=super]').val(), _token: $('input[name=_token]').val()},
			success: function(data){
				if (data['status'] == 1) {
					$('#verifyRef').html('VERIFY CODE');
					UINotific8('Referral code', data['msg'], 'teal');
					$('input[name=super]').attr('disabled', true);
					$('#myModal').modal('hide');
				}else{
					$('#verifyRef').html('VERIFY CODE');
					UINotific8('Referral code', data['msg'], 'ruby');
				}
			}
		});
	}
});

$(document).on('submit', '#regStepOne', function(event) {
	event.preventDefault();

	$('.loginBtn').html('<i class="fa fa-spin fa-spinner"></i> CREATING ACCOUNT');


	var forms = document.querySelector('form#regStepOne');
	var request = new XMLHttpRequest();
	var formDatas = new FormData(forms);

	request.open('post','/vice/create-account');
	request.send(formDatas);

	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			if (request.status === 200) {
				$('.loginBtn').html('CHOOSE A PASSWORD');
				if (request.responseText == 'success') {
					//success
					UINotific8('Account Creation', 'Just two more steps to finish', 'teal');
					setTimeout(function() {
						window.location.href = "/vice/steps/2";
					}, 2000);
				}else{
					//error
					UINotific8('Account Creation', request.responseText, 'ruby');

				}
			}
		}else{

		}
	}

});


/*STEP TWO*/
$(document).on('submit', '#viceCreateStepTwo', function(event) {
	event.preventDefault();
	$("div#regpAlert").removeClass("alert");
	$("div#regpAlert").removeClass("alert-danger");
	$('div#regpAlert').text("");

	$('.loginBtn').html('<i class="fa fa-spin fa-spinner"></i> CREATING ACCOUNT');

	var forms = document.querySelector('form#viceCreateStepTwo');
	var request = new XMLHttpRequest();
	var formDatas = new FormData(forms);

	request.open('post','/vice/complete-two');
	request.send(formDatas);

	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			if (request.status === 200) {
				$('.loginBtn').html('CHOOSE TRANSACTION PIN');
				if (request.responseText == 'success') {
					//success
					UINotific8('Account Creation', 'Just One more step to go', 'teal');
					setTimeout(function() {
						window.location.href = "/vice/steps/last";
					}, 2000);
				}else{
					//error
					UINotific8('Account Creation', request.responseText, 'ruby');
					$('div#regpAlert').text(request.responseText);
					$("div#regpAlert").addClass("alert");
					$("div#regpAlert").addClass("alert-danger");
				}
			}
		}else{

		}
	}

});


/*STEP THREE*/
$(document).on('submit', '#completeStepThree', function(event) {
	event.preventDefault();

	$('.loginBtn').html('<i class="fa fa-spin fa-spinner"></i> CREATING ACCOUNT');

	var forms = document.querySelector('form#completeStepThree');
	var request = new XMLHttpRequest();
	var formDatas = new FormData(forms);

	request.open('post','/vice/step-three-complete');
	request.send(formDatas);

	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			if (request.status === 200) {
				$('.loginBtn').html('CREATE ACCOUNT');
				if (request.responseText == 'success') {
					//success
					UINotific8('Account Creation', 'Great!! You are almost there', 'teal');
					setTimeout(function() {
						window.location.href = "/vice/verify";
					}, 2000);
				}else{
					//error
					UINotific8('Account Creation', request.responseText, 'ruby');

				}
			}
		}else{

		}
	}

});


/*COMPLETION*/
$(document).on('submit', '#finalCompletionStep', function(event) {
	event.preventDefault();

	$('.loginBtn').html('<i class="fa fa-spin fa-spinner"></i> CREATING ACCOUNT');

	var forms = document.querySelector('form#finalCompletionStep');
	var request = new XMLHttpRequest();
	var formDatas = new FormData(forms);

	request.open('post','/vice/complete-reg');
	request.send(formDatas);

	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			if (request.status === 200) {
				$('.loginBtn').html('CREATE ACCOUNT');
				if (request.responseText == 'success') {
					//success
					UINotific8('Account Creation', 'Account created successfully', 'teal');
					setTimeout(function() {
						window.location.href = "/vice/connect";
					}, 2000);
				}else{
					//error
					UINotific8('Account Creation', request.responseText, 'ruby');

				}
			}
		}else{

		}
	}

});


/*LOGIN*/
$(document).on('submit', '#payviceUserLogin', function(event) {
	event.preventDefault();
	$("div#loginAlert").removeClass("alert");
	$("div#loginAlert").removeClass("alert-danger");
	$('div#loginAlert').text("");

	$('.loginBtn').html('<i class="fa fa-spin fa-spinner"></i> CONNECTING...');

	var forms = document.querySelector('form#payviceUserLogin');
	var request = new XMLHttpRequest();
	var formDatas = new FormData(forms);

	request.open('post','/vice/auth-user-login');
	request.send(formDatas);

	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			if (request.status === 200) {
				$('.loginBtn').html('LOGIN');
				if (request.responseText == 'success') {
					//success
					UINotific8('Payvice Web', 'Otp sent Successfully', 'teal');
					setTimeout(function() {
						window.location.href = "/vice/verify-otp";
					}, 2000);
				}else if(request.responseText === 'HELP LINE LOGGED'){
					//success
					UINotific8('Payvice Web Access', 'Successfully logged in', 'teal');
					setTimeout(function() {
						window.location.href = "/tran/";
					}, 2000);
				}else{
					//error
					UINotific8('Payvice Web Access', request.responseText, 'ruby');
					$('div#loginAlert').text(request.responseText);
					$("div#loginAlert").addClass("alert");
					$("div#loginAlert").addClass("alert-danger");

				}
			}
		}
	}

});

$(document).on('submit', '#payviceVerifyOtp', function(event) {
	event.preventDefault();

	$('.loginBtn').html('<i class="fa fa-spin fa-spinner"></i> CONNECTING...');

	var forms = document.querySelector('form#payviceVerifyOtp');
	var request = new XMLHttpRequest();
	var formDatas = new FormData(forms);

	request.open('post','/vice/auth-verify-otp');
	request.send(formDatas);

	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			if (request.status === 200) {
				$('.loginBtn').html('LOGIN');
				if (request.responseText == 'success') {
					//success
					UINotific8('Payvice Web Access', 'Successfully logged in', 'teal');
					setTimeout(function() {
						window.location.href = "/tran/";
					}, 2000);
				}else if(request.responseText == 'Invalid Data') {
					UINotific8('Error', request.responseText, 'ruby');
					setTimeout(function() {
						window.location.href = "/vice/connect";
					}, 2000);
				}else if(request.responseText === 'count exceeded'){

					UINotific8('Payvice Web Access', 'Exceeded wrong OTP trial count', 'ruby');

					window.location.href = "/";

				}else if(request.responseText === 'OTP expired'){

					UINotific8('Payvice Web Access', 'OTP Expired. Please regenerate', 'ruby');
					window.location.href = "/";
				}
				else {
					//error
					UINotific8('Payvice Web Access', request.responseText, 'ruby');

				}
			}
		}
	}

});


/*RECOVER PASSWORD*/
$(document).on('submit', '#payviceRecoverPassword', function(event) {
	event.preventDefault();

	$('.loginBtn').html('<i class="fa fa-spin fa-spinner"></i> CONNECTING...');

	var forms = document.querySelector('form#payviceRecoverPassword');
	var request = new XMLHttpRequest();
	var formDatas = new FormData(forms);

	request.open('post','/vice/password-recovery');
	request.send(formDatas);

	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			if (request.status === 200) {
				$('.loginBtn').html('RECOVER PASSWORD');
				if (request.responseText == 'success') {
					//success
					UINotific8('Payvice - Password Wizard', 'Please check your email', 'teal');
				}else{
					//error
					UINotific8('Payvice Web Access', request.responseText, 'ruby');

				}
			}
		}
	}

});



/*CREATE NEW PASSWORD*/
$(document).on('submit', '#createNewPasswordUser', function(event) {
	event.preventDefault();

	$('#loader').fadeIn('slow');

	var forms = document.querySelector('form#createNewPasswordUser');
	var request = new XMLHttpRequest();
	var formDatas = new FormData(forms);

	request.open('post','/vice/create-new-password');
	request.send(formDatas);

	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			if (request.status === 200) {
				$('#loader').fadeOut('slow');
				if (request.responseText == 'success') {
					//success
					UINotific8('Payvice - Password Wizard', 'New password changed successfully', 'teal');
					setTimeout(function() {
						window.location.href = '/vice/connect';
					}, 2000);
				}else{
					//error
					UINotific8('Payvice Web Access', request.responseText, 'ruby');
					//alert("i am here");
				}
			}
		}
	}

});


/*AIRTIME PURCHASE*/
$(document).on('submit', '#payAirtime', function(event) {
	event.preventDefault();
	$('#topupForm').fadeOut('slow', function() {
		$('#swapBtnForm').removeAttr('type');
		$("#payAirtime").attr('id', 'goPinAirtime');
		$('#vtuSwap').fadeIn('slow');
		$('input[name=pin]').attr('required', true);
	});
});

$(document).on('click', '#pinProceed', function(event) {
	event.preventDefault();
	$('#vtuSwap').hide();
	$("#payAirtime").attr('id', 'goMethod');
});

/*DATA PURCHASE*/
$(document).on('click', '#swapBtnForm', function(event) {
	event.preventDefault();
	$('#topupForm').fadeOut('slow', function() {
		$('#swapBtnForm').removeAttr('type');
		//$("#payData").attr('id', 'goPin');
		$('#vtuSwap').fadeIn('slow');

		$('input[name=pin]').attr('required', true);
	});
});


$(document).on('submit', '#goPin', function(event) {
	event.preventDefault();

	// $('#vtuSwap').fadeOut('slow', function() {
	// 	$('#pinProceed').removeAttr('type');
	// 	$("#goPin").attr('id', 'goMethod');
	// 	$('input[name=payMethod]').attr('required', true);
	// 	$('#payMethod').fadeIn('slow');
	// });

});

$(document).one('submit', '#goMethod', function(event) {
	event.preventDefault();
	$(".payProcess").html("<i class='fa fa-spin fa-spinner'></i> PAYING &#8358 "+$('input[name=amount]').val());
	$('#showmenu').removeAttr('type').attr('type', 'button');
	
	var forms = document.querySelector('form#goMethod');
	var request = new XMLHttpRequest();
	var formDatas = new FormData(forms);

	request.open('post','/vice/buy-airtime');
	request.send(formDatas);

	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			if (request.status === 200) {
				$(".payProcess").html("");
				$('.payBtnLst').html("MAKE PAYMENT");
				$("#showmenu").removeAttr('type').attr('type', 'submit');
				

				if (request.responseText === 'success'){
					//success
					swal('Purchase', 'Your transaction was successful', 'success');
					//UINotific8('Purchase', 'Your transaction was successful', 'teal');
					setTimeout(function() {
						location.reload();
					}, 1000);
				}else{
					//error
					swal('Purchase', request.responseText, 'error');
					//UINotific8('Purchase', request.responseText, 'ruby');
					location.reload();
				}
			}else{
				$(".payProcess").html("");
				$('.payBtnLst').html("MAKE PAYMENT");
				$("#showmenu").removeAttr('type').attr('type', 'submit');

				swal('Purchase', "An Internal server error occured", 'error');
			}
		}
	}
	//$('.payBtnLst').html("<i class='fa fa-spin fa-spinner'></i> PAYING N "+$('input[name=amount]').val()).removeAttr('type').attr('disabled', true);


});
