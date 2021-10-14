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
					UINotific8('Payvice Web Access', 'Successfully logged in', 'teal');
					setTimeout(function() {
						window.location.href = "/tran/";
					}, 2000);
				}else{
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
		$("#payAirtime").attr('id', 'goPin');
		$('#vtuSwap').fadeIn('slow');

		$('input[name=pin]').attr('required', true);
	});
	


});

$(document).on('submit', '#goPin', function(event) {
	event.preventDefault();

	$('#vtuSwap').fadeOut('slow', function() {
		$('#pinProceed').removeAttr('type');
		$("#goPin").attr('id', 'goMethod');
		$('input[name=payMethod]').attr('required', true);
		$('#payMethod').fadeIn('slow');
	});
	
});


$(document).on('submit', '#goMethod', function(event) {
	event.preventDefault();

	$('.payBtnLst').html("<i class='fa fa-spin fa-spinner'></i> PAYING N "+$('input[name=amount]').val());
	var forms = document.querySelector('form#goMethod');
	var request = new XMLHttpRequest();
	var formDatas = new FormData(forms);

	request.open('post','/vice/buy-airtime');
	request.send(formDatas);

	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			if (request.status === 200) {
				$('.payBtnLst').html("MAKE PAYMENT");
				if (request.responseText === 'success'){
					//success
					swal('Purchase', 'Your transaction was successful', 'success');
					//UINotific8('Purchase', 'Your transaction was successful', 'teal');
					setTimeout(function() {
						location.reload();
					}, 2000);
				}else{
					//error
					swal('Purchase', request.responseText, 'error');
					//UINotific8('Purchase', request.responseText, 'ruby');

				}
			}
		}
	}

});





