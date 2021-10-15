<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PayviceHandler@getHomePage');

/*
Route::get('/encrypt', function () {
    $jsonParams = [
        'meterNo' => '4620980563',
        'accountType' => 'prepaid',
        'service' => 'ikedc',
        'amount' => '100',
        'channel' => 'WEB'
	];
	$jsonParams = [
		"accountNo" => "0118304901",
    "bankCode" => "000013",
    "service" => "transfer",
    "channel" => "MOBILE",
    "amount" => "8000"
	];

    $key = 'b83cef088a4943231342c7fd53b6502d';

    $encodedBody = json_encode($jsonParams, true);
    
    $hmac = hash_hmac("sha256", $encodedBody, $key);
    return $hmac;
});
*/

Route::get('/play', function () {
	return view('transfer-commission');
});

Route::post('/transfer-comssmission/process', function () {

	$allSent = request()->all();

	return response()->json($allSent);
});

<<<<<<< HEAD
<<<<<<< HEAD
=======

>>>>>>> cb07576dd8260ccd0360d8a936eecad35aac01ef
=======
>>>>>>> 457ce7d49e7e84554390407e86f4389abe197130
Route::get('/vice/terms-and-conditions', function () {
	return view('terms');
});

/**
 * Agent Onboarding Routes
 */
// Route Group for Webpages
Route::group(['prefix' => 'vice/agents'], function(){

	Route::get('/onboard', 'AgentController@getPage')->name('onboardHome');
	Route::post('/save-data', 'AgentController@regAgent')->name('regAgent');
	Route::post('/validate-phone', 'AgentController@validateAgentPhone');
	Route::get('/verify-activation-code', 'AgentController@verifyActivationCode')->name('verify-activation-code');
	Route::post('/verify-activation-code', 'AgentController@confirmActivationCode');
	Route::get('/merchant-details', 'AgentController@merchantDetails')->name('verify-activation-code');
	Route::post('/save-biodata', 'AgentController@saveBioData')->name('save-biodata');
	Route::get('/uploads', 'AgentController@uploadsPage')->name('uploads');
	Route::post('/uploads', 'AgentController@uploadDocuments')->name('upload-documents');
	Route::get('/completed', 'AgentController@completed');
	
});



Route::get('/vice/connect', function () {
	return view('login');
});

<<<<<<< HEAD
<<<<<<< HEAD
=======


>>>>>>> cb07576dd8260ccd0360d8a936eecad35aac01ef
=======
>>>>>>> 457ce7d49e7e84554390407e86f4389abe197130
Route::get('/vice/verify-otp', function () {
	return view('verify-otp');
});

// Route::get('/vice/api/doc', function () {
// 	return view('apidoc');
// });

Route::get('/ag/banking', function () {
	return view('agency');
});
Route::get('/ag/agency-banking', function () {
	return view('agency_v2');
});

Route::get('/vice/my-pass', function () {
	return view('recover');
});

Route::get('/vice/access', function () {
	return view('register');
});

Route::get('/vice/terms-and-conditions', function () {
	return view('terms');
});

Route::get('/vice/pass-wiz-one', function () {
	\Session::put('usrEml', $_GET['userid']);
	\Session::put('userTid', $_GET['tid']);

	return redirect('/vice/pass-meter');

});

Route::get('/vice/pass-meter', function () {
	if (null == \Session::get('usrEml') || null == \Session::get('userTid'))
		return redirect('/');

	return view('new-pass-create', ['email' => \Session::get('usrEml'), 'tid' => \Session::get('userTid')]);
	//new-pass
});

Route::get('/otp/pass', function(){
	return view('new-pass-create');
});

Route::get('/vice/create', 'PayviceController@register');
/*function () {
	return view('register');
}*/

Route::get('/vice/complete', 'PayviceController@completion');

Route::get('/vice/home', function(){
	return view('dashboard');
});

Route::get('/vice/verify', function(){
	if (null != \Session::get('userTran')) {
		return view('verify');
	}else{
		return redirect('/vice/steps/last')->with('accessError', 'You have not completed step three');
	}

});

Route::get('/vice/steps/2', function(){
	if (null != \Session::get('clr') && null != \Session::get('userTID') && null != \Session::get('userEmail')) {
		return view('step-two');
	}else{
		return redirect('/vice/access')->with('accessError', 'You have not completed step one');
	}

});


Route::get('/vice/steps/last', function(){
	if (null != \Session::get('passStepTwo')) {
		return view('step-three');
	}else{
		return redirect('/vice/steps/2')->with('accessError', 'You have not completed step two');
	}

});

Route::group(['prefix' => 'dashboard', 'middleware' => 'payvice'], function(){

	Route::get('/transaction-history', 'AccountController@dashboard');
	Route::get('/account-history', 'AccountController@ft_dashboard');

});

<<<<<<< HEAD
<<<<<<< HEAD
=======
// support route
// Route::get('/support', 'AccessController@support');


>>>>>>> cb07576dd8260ccd0360d8a936eecad35aac01ef
=======
>>>>>>> 457ce7d49e7e84554390407e86f4389abe197130
// Route Group for Webpages
Route::group(['prefix' => 'tran', 'middleware' => 'payvice'], function(){
	Route::get('/', 'AccessController@payviceHome');

	Route::get('/airtime', 'AccessController@getAirtime');

	Route::get('/data', 'AccessController@getData');

	Route::get('/paybills', 'AccessController@getPayBills');

<<<<<<< HEAD
=======
	Route::get('/movie_tickets', 'AccessController@getMovieTickets');

>>>>>>> 457ce7d49e7e84554390407e86f4389abe197130
	Route::get('/account', 'AccessController@getWallet');

	Route::get('/trhistory', 'AccessController@getTrHistory');

	Route::get('/settings', 'AccessController@getUserSettings');
<<<<<<< HEAD
<<<<<<< HEAD
=======
	Route::get('/support', 'AccessController@getSupport');
>>>>>>> cb07576dd8260ccd0360d8a936eecad35aac01ef
=======
>>>>>>> 457ce7d49e7e84554390407e86f4389abe197130
	Route::get('/reset-pin', 'AccessController@resetTransPin');
	Route::post('/reset-pin', 'AccessController@newTransPin');

	Route::get('/get-agent-tran', 'AccessController@getAgentTran');
	Route::get('/getAgentListDetails', 'AccessController@getAllSubAgents');
	Route::get('/multi/getplans', 'VasController@getMultiSubPlans');
	Route::get('/smile/getplans', 'VasController@getSmileSubPlans');

	/*POST ROUTES*/
});


Route::get('/transfer-commission', 'CommissionController@index')->middleware('payvice');

Route::post('/transfer-commission', 'CommissionController@transfer')->middleware('payvice');

Route::get('/vice/disconnect', 'AccessController@flushAuthUser');



/*POST ROUTE*/
Route::post('/vice/create-account', 'PayviceHandler@postStepOne');
Route::post('/vice/complete-two', 'PayviceHandler@postRegPhaseTwo');
Route::post('/vice/step-three-complete', 'PayviceHandler@completeStepThree');
Route::post('/vice/complete-reg', 'PayviceHandler@postCompletionUser');
// Route::post('/vice/proceed/plan', 'VasController@proceedMultichoicePlan');
// Route::post('/vice/smile/proceed', 'VasController@proceedSmilePlan');


// Route::post('/vice/proceed/pin', 'VasController@proceedMultichoiceTranPin');
// Route::post('/vice/proceed/pay', 'VasController@makePaymentMultichoice');
// Route::post('/vice/smile/pay', 'VasController@makePaymentSmile');

// Route::post('/vice/makeMultiChoice/PaySub', 'VasController@subMultiChoice');


Route::post('/vice/auth-user-login', 'AccessController@userAuthOtp');
Route::post('/vice/auth-verify-otp', 'AccessController@userAuth');
Route::post('/vice/buy-airtime', 'AccessController@purchaseAirtime');

Route::get('/vice/{tid}/{useremail}', 'AccessController@getTrHistoryForMobile');
Route::post('/vice/password-recovery', 'PayviceHandler@getUserNewPassword');
Route::post('/vice/create-new-password', 'PayviceHandler@PostUserNewPassword');
Route::post('/vice/myBprovider', 'PayviceController@myBprovider');
Route::post('/vice/genToken', 'PayviceController@generateToken');
Route::post('/vice/verify/ref', 'PayviceHandler@verifyNewReferral');
