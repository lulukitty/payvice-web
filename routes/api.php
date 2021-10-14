<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/tran/purchase', 'AccessController@processApiCall');
Route::post('/tran/auth0/lookup', 'AccessController@lookup');
Route::post('/tran/auth0/PTMLtoITEX', 'AccessController@PTMLtoITEX');
Route::post('/tran/auth0/purchase', 'AccessController@processApiCallVisionTek');
Route::post('/tran/auth0/requery', 'AccessController@requeryTxn');
Route::post('/tran/auth0/ie', 'AccessController@ikedcAgent');
Route::post('/tran/auth0/ietest', 'AccessController@ikedcAgentTest');
// Route::post('/tran/auth0/walletBaltest', 'AccessController@lowerAgentWalletTest');
// Route::post('/tran/auth0/walletBal', 'AccessController@lowerAgentWallet');

Route::post('/tms/auth0/notify', 'IisysgroupController@tranNotification');

Route::post('/tran/auth2/lookup', 'PayviceController@lookup');
Route::post('/tran/auth2/purchase', 'PayviceController@processApiCallVisionTek');
Route::post('/tran/auth2/ie/tran', 'PayviceController@purchaseIkejaElectricity');

// Route::post('/tran/auth2/wallet/transfer', 'PayviceController@walletTowalletTran');

Route::post('/tran/auth2/bill/tv', 'VasController@getMultiChoiceLookup');
Route::post('/tran/auth2/bill/validate', 'VasController@getMultiChoiceAccountDetails');
Route::post('/tran/auth2/tv/pay', 'VasController@processPayMultichoice');


Route::post('/account', 'AccountController@index');
Route::post('/account/wallet-lookup', 'AccountController@walletLookup');
Route::post('/account/wallet-transfer', 'AccountController@walletTransfer');

/*TRANSACTION MONITORING ROUTES*/
Route::post('/tms/iisys/auth2', 'IisysgroupController@newTranJournal');

Route::get('/tran/check/{wallet}', 'AccessController@getAllTxn');

/*External Authentication*/

Route::group(['prefix' => 'providers'], function(){

	Route::post('/auth/signup/{providerKey}', 'ExternalProvidersController@signup');
	Route::post('/auth/verify/{providerKey}', 'ExternalProvidersController@verify');
	Route::post('/auth/login/{providerKey}', 'ExternalProvidersController@login');

});


/*GTB FINANCIAL*/
// Route::post('/banking/validate/auth2', 'BankingController@lookupAccount');
// Route::post('/banking/transfer/auth2', 'BankingController@toAccountTransfer');
// Route::post('/banking/cashout/auth2', 'BankingController@cashWithdrawal');
// Route::post('/banking/deposit/auth2', 'BankingController@cashDeposit');

/*CARD TRANSACTION*/
// Route::post('/banking/card/tran/auth2', 'BankingController@migsCardtransactions');


/*EKO ELECTRICITY*/
// Route::post('/tran/eko/lookup', 'VasController@validateEkoCustomer');
// Route::post('/tran/auth2/eko/pay', 'VasController@makeEkoPayment');


/*ENUGU ELECTRICITY*/
// Route::post('/tran/enugu/lookup', 'VasController@validateEnuguCustomer');
// Route::post('/tran/auth2/enugu/pay', 'VasController@enuguElectPayment');

/* Route Group for Multichoice */
Route::group(['prefix' => '/multichoice'], function(){
	Route::post('/vas/validate', 'MultichoiceController@validateIUC')->name('validateIUC');
	Route::post('/vas/pay', 'MultichoiceController@payMultichoice')->name('payMultichoice');
});

/* Route Group for Mobile Data */
Route::group(['prefix' => '/mobiledata'], function(){
	Route::get('/vas/data/validate', 'MobileDataController@mobileDataLookup')->name('mobileDataLookup');
	Route::post('/vas/data/pay', 'MobileDataController@paySubscription')->name('paySubscription');
});

//.
/* Route Group for Utilities */
Route::group(['prefix' => '/utility'], function(){
	// Eko Electric
	Route::post('/vas/ekedc/validate', 'EkoController@meterLookup')->name('meterEkoLookup');
	// Route::post('/vas/ekedc/pay', 'EkoController@payUtility')->name('payEkoUtility'); 

	// Ikeja Electric
	Route::post('/vas/ikedc/validate', 'IEController@meterLookup')->name('meterIELookup');
	// Route::post('/vas/ikedc/pay', 'IEController@payUtility')->name('payIEUtility');

	// Ibadan Electric
	Route::post('/vas/ibedc/validate', 'IBEController@meterLookup')->name('meterIBELookup');
	// Route::post('/vas/ibedc/pay', 'IBEController@payUtility')->name('payIBEUtility');

	// Enugu Electric
	Route::post('/vas/eedc/validate', 'EEController@meterLookup')->name('meterEELookup');
	// Route::post('/vas/eedc/pay', 'EEController@payUtility')->name('payEEUtility');

	// PortHarcourt Electric
	Route::post('/vas/phedc/validate', 'PHEController@meterLookup')->name('meterPHELookup');
	// Route::post('/vas/phedc/pay', 'PHEController@payUtility')->name('payPHEUtility');


	// Abuja Electric
	Route::post('/vas/aedc/validate', 'AEController@meterLookup')->name('meterAELookup');
	// Route::post('/vas/aedc/pay', 'AEController@payUtility')->name('payAEUtility');

	// Kaduna Electric
	Route::post('/vas/kedc/validate', 'KEController@meterLookup')->name('meterKELookup');
	// Route::post('/vas/kedc/pay', 'KEController@payUtility')->name('payKEUtility');
	
	Route::post('/vas/electricity/pay', 'VasFourOperations@payElectricity');
	
});

/* Route Group for internet */
Route::group(['prefix' => '/internet'], function(){
	Route::post('/smile/validate', 'VasFourOperations@validateSmileAccount');
	Route::post('/smile/pay', 'VasFourOperations@smilePayment');
	// Route::post('/vas/data/pay', 'MobileDataController@paySubscription')->name('paySubscription');
});
