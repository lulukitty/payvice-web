<?php

/*
* @author Michel Kalavanda
* www.iisysgroup.com
*/

namespace App\Http\Controllers;

use Payvice;
use App\Vice;
use App\Account;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\HttpRequests;
use \GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\VasFourOperations;

class AccessController extends Controller
{
	public $viceUser;
	public $viceID;
	public $viceEmail;
	public $vasOperations;
	public $client;

	public function __construct(){
		$this->viceUser = \Session::get('curUsr');
		$this->viceID = \Session::get('curAcc');
		$this->viceEmail = \Session::get('curEm');
		$this->helper = new HelperController;
		$this->vasOperations = new VasFourOperations;
		$this->client = new \GuzzleHttp\Client([ 'verify' => false ]);
	}


/*
	public function payviceHome(){

		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=BALANCE&termid='.\Session::get('curAcc').'&userid='.\Session::get('curEm'));
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);

			$getBalance = $phpArray;
		}


		$history = new \GuzzleHttp\Client();
		$clientHistory = $history->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=RECORDS&termid='.\Session::get('curAcc').'&userid='.\Session::get('curEm'));
		if ($clientHistory->getStatusCode() == 200) {
			$cltContents = str_replace(array("\n", "\r", "\t"), '', $clientHistory->getBody()->getContents());
			$cltContents = trim(str_replace('"', "'", $cltContents));
			$cltXml = simplexml_load_string($cltContents);
			$jsonClt = json_encode($cltXml);
			$cltArray = json_decode($jsonClt, true);

			$getHistory = $cltArray;
		}

		$block = explode("*", $getHistory['tran']['message']);

		$filter = array_filter($block, function($var){return $var !== ''; } );

		print_r($filter);
		exit();
		$balance = explode('N', $phpArray['tran']['balance']);
		return view('dashboard', ['balance' => $balance[1], 'hist' => $filter]);
	}
*/

	public function payviceHome(Request $request){
		// $history = new \GuzzleHttp\Client();
		// $clientHistory = $history->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=RECORDS&termid='.\Session::get('curAcc').'&userid='.\Session::get('curEm'));
		
		// if ($clientHistory->getStatusCode() == 200) {
		// 	$cltContents = str_replace(array("\n", "\r", "\t"), '', $clientHistory->getBody()->getContents());
		// 	$cltContents = trim(str_replace('"', "'", $cltContents));
		// 	$cltXml = simplexml_load_string($cltContents);
		// 	$jsonClt = json_encode($cltXml);
		// 	$cltArray = json_decode($jsonClt, true);

		// 	$getHistory = $cltArray;
		// }

		// $block = explode("*", $getHistory['tran']['message']);

		// Log::info('RESPONSE FROM TAMS', [$block]);

		// $filter1 = array_filter($block, function($var){return $var !== ''; } );

		$data['UserDetails'] = $this->getUserDetails($request);
		$walletId = $data['UserDetails']['wallet_id'];
		$userEmail = $data['UserDetails']['email'];
		// Get Wallet Balance Details
		$balanceDetails = Account::balance($walletId, $userEmail);

		Log::info('ACCOUNT BALANCE RESPONSE LOG', [$balanceDetails]);
		
		$balanceDetails = (array) $balanceDetails;
		$data['balance'] = number_format($balanceDetails['balance'], 2);

		$data['commissionBalance'] = number_format($balanceDetails['commission'], 2);
		//$data['hist'] = $filter1;

		if(session('PASSWORD_CHANGED') === 'changed'){
			return redirect('/tran/reset-pin');
			// session()->forget('PASSWORD_CHANGED')
		}

		return view('dashboard', $data);

		// $client = new \GuzzleHttp\Client();
		// $res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=BALANCE&termid='.\Session::get('curAcc').'&userid='.\Session::get('curEm'));

		// if ($res->getStatusCode() == 200) {
		// 	$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
		// 	$fileContents = trim(str_replace('"', "'", $fileContents));
		// 	$simpleXml = simplexml_load_string($fileContents);
		// 	$json = json_encode($simpleXml);
		// 	$phpArray = json_decode($json, true);

		// 	$getBalance = $phpArray;

		// 	//dd($getBalance);
		// }

		// $balance = explode('N', $phpArray['tran']['balance']);

		// //Check if Commission Balance Exists
		// $commissionBalance = 0;
		// if(isset($getBalance['tran']['commission'])) {
		// 	$commissionBalanceArray = explode('N', $phpArray['tran']['commission']);
		// 	if(isset($commissionBalanceArray[1])){
		// 		$commissionBalance = $commissionBalanceArray[1];
		// 	}
		// }

		// /*
		// * IF THE USER IS IKEJA ELECTRIC MERCHANT
		// */
		// $ieTran = "";
		// try{
		// 	$getIE = $history->get('http://basehuge.itexapp.com:8093/api/get/Ie/tran/'.\Session::get('curAcc'));

		// 	if ($getIE->getStatusCode() == 200) {

		// 		$ieTran = json_decode($getIE->getBody()->getContents(), true);
		// 	}

		// } catch(\Exception $e){

		// }

		// /*
		// * If merchant has sub-agents
		// */
		// $ag = [];

		// $sub = new \GuzzleHttp\Client();
		// $clientHistory = $sub->post('http://197.253.19.75/tams/eftpos/devinterface/transactionadvice.php?action=PAYVICE_SUB_AGENT&termid=203301ZA&vice_id='.\Session::get('curAcc'));
		// if ($clientHistory->getStatusCode() == 200) {
		// 	$cltContents = str_replace(array("\n", "\r", "\t"), '', $clientHistory->getBody()->getContents());
		// 	$cltContents = trim(str_replace('"', "'", $cltContents));
		// 	$cltXml = simplexml_load_string($cltContents);
		// 	$jsonClt = json_encode($cltXml);
		// 	$cltArray = json_decode($jsonClt, true);


		// 	foreach ($cltArray['efttran'] as $msg) {
		// 		$mg = json_decode($msg, true);
		// 		array_push($ag, $mg);
		// 	}


		// 	//return view('list-agent', ['list' => $filter]);
		// }

		// $filter = array_filter($ag, function($var){return $var !== ''; } );


	}

	public function userAuth(Request $usr){
		// return $usr->all();
		$validate = \Validator::make($usr->all(), [
			'otp' => 'bail|required'
		],
		[
			'otp.required' => 'OTP is required'
		]);

		if ($validate->fails())
			return $validate->messages();

		$details = session('userDetails');

		if($details == null){
			\Session::flush();

			return 'Invalid Data';
		}

		$userDetails = json_decode($details, true);
		
		// return $userDetails;

		if($usr->otp !== $userDetails['otp']){

			session()->push('otpTrialCount', +1);


			if (session('otpTrialCount') > 2) {

				\Session::flush();
				
				return 'count exceeded';

			}if(\Payvice::tokenExpiration(session('otpGeneratedAt')) == true){

				return 'OTP expired';
			}
			else{

				return 'OTP does not match';
			}

			
		}
		// return 'otp Match';


		/*INIT*/
		// $client = new \GuzzleHttp\Client();
		// $res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$usr->email.'&control=INIT');
		// if ($res->getStatusCode() == 200) {
		// 	$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
		// 	$fileContents = trim(str_replace('"', "'", $fileContents));
		// 	$simpleXml = simplexml_load_string($fileContents);
		// 	$json = json_encode($simpleXml);
		// 	$phpArray = json_decode($json, true);
		// 	//dd($phpArray);
		// 	/*print_r($phpArray);
		// 	exit();*/

		// 	Log::info('TAMS LOGIN RESPONSE', [$phpArray]);


		// 	if ($phpArray['tran']['result'] == 1) {
		// 		return $phpArray['tran']['message'];
		// 	}else{
		// 		$usrTID = $phpArray['tran']['macros_tid'];
		// 		$getKey = explode('|', $phpArray['tran']['message']);
		// 		$key = $getKey[1];

		// 		$tidArray = str_split($usrTID);
		// 		$createClrKey = "";

		// 		foreach ($tidArray as $tidChar) {
		// 			if (!is_numeric($tidChar))
		// 				$tidChar = 7;
		// 			$createClrKey .= substr($key, $tidChar, 1);

		// 		}

		// 		$hex = hex2bin($createClrKey);
		// 		$pass = $hex.$usr->password;


		// 		$encryptedPassword = hash('SHA256', $pass);

		// 		$usr->session()->put('usrKeyPass', $encryptedPassword);
		// 		$usr->session()->put('clearPass', $usr->password);


				/*echo $encryptedPassword.'<br> >>>>>'.$createClrKey;
				exit();*/

				$login = new \GuzzleHttp\Client();
				$res = $login->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid='.$userDetails['tid'].'&userid='
					.$userDetails['email'].'&password='.$userDetails['encPassword']);
				if ($res->getStatusCode() == 200) {
					$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
					$fileContents = trim(str_replace('"', "'", $fileContents));
					$simpleXml = simplexml_load_string($fileContents);
					$json = json_encode($simpleXml);
					$phpArray = json_decode($json, true);

					// dd($res);
					/*print_r($phpArray);
					exit();*/


					if ($phpArray['tran']['result'] == 1)
						return $phpArray['tran']['message'];

					$userData = explode("|", $phpArray['tran']['message']);

					$userCredentials = [
						'email' => $userData[5],
						'name' =>  $userData[0],
						'account' => $userData[2]
					];

					$name = explode('<macros>', $userData[0]);

					// Get auth Api token
					$tokenResponse = $this->vasOperations->getAuthToken($userData[2], $userData[5], session('clearPass'));

					if($tokenResponse['responseCode'] == "00"){
						$usr->session()->put('authToken', $tokenResponse['data']['apiToken']);
					}else{
						return $tokenResponse['message'];
					}

					$usr->session()->put('curUsr', $name[0]);
					$usr->session()->put('curAcc', $userData[2]);
					$usr->session()->put('curEm', $userData[5]);

					// \Log::info('All Session Data'. print_r(session()->all(), true));

					session()->forget('userDetails');



					return "success";

				}

				return 'Process Failed';

			// }
		// }

			}

			public function userAuthOtp(Request $usr){
				$validate = \Validator::make($usr->all(), [
					'email' => 'bail|required',
					'password' => 'bail|required'
				],
				[
					'email.required' => 'Email/Phone Number is required',
					'password.required' => 'Password is Required'
				]);

				if ($validate->fails())
					return $validate->messages();

		// if( !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $usr->password)){
		// 	return 'Password Must contain at least one lowercase, one uppercase and one number, Please Update Password';
		// };

				/*INIT*/
				$client = new \GuzzleHttp\Client();
				$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$usr->email.'&control=INIT');
				if ($res->getStatusCode() == 200) {
					$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
					$fileContents = trim(str_replace('"', "'", $fileContents));
					$simpleXml = simplexml_load_string($fileContents);
					$json = json_encode($simpleXml);
					$phpArray = json_decode($json, true);
			//dd($phpArray);
			/*print_r($phpArray);
			exit();*/

			Log::info('TAMS LOGIN RESPONSE', [$phpArray]);


			if ($phpArray['tran']['result'] == 1) {
				return $phpArray['tran']['message'];
			}else{
				$usrTID = $phpArray['tran']['macros_tid'];
				$getKey = explode('|', $phpArray['tran']['message']);
				$key = $getKey[1];

				$tidArray = str_split($usrTID);
				$createClrKey = "";

				foreach ($tidArray as $tidChar) {
					if (!is_numeric($tidChar))
						$tidChar = 7;
					$createClrKey .= substr($key, $tidChar, 1);

				}

				$hex = hex2bin($createClrKey);
				$pass = $hex.$usr->password;


				$encryptedPassword = hash('SHA256', $pass);

				$usr->session()->put('usrKeyPass', $encryptedPassword);
				$usr->session()->put('clearPass', $usr->password);


				/*echo $encryptedPassword.'<br> >>>>>'.$createClrKey;
				exit();*/

				if($usrTID == "44952823"){
					\Log::info("HELP LINE TERMINAL ID DETECTED $usrTID");

					$login = new \GuzzleHttp\Client();
					$res = $login->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid='.$usrTID.'&userid='.$usr->email.'&password='.$encryptedPassword);
					if ($res->getStatusCode() == 200) {
						$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
						$fileContents = trim(str_replace('"', "'", $fileContents));
						$simpleXml = simplexml_load_string($fileContents);
						$json = json_encode($simpleXml);
						$phpArray = json_decode($json, true);

						if ($phpArray['tran']['result'] == 1)
							return $phpArray['tran']['message'];

						$userData = explode("|", $phpArray['tran']['message']);

						$userCredentials = [
							'email' => $userData[5],
							'name' =>  $userData[0],
							'account' => $userData[2]
						];

						$name = explode('<macros>', $userData[0]);


						$usr->session()->put('curUsr', $name[0]);
						$usr->session()->put('curAcc', $userData[2]);
						$usr->session()->put('curEm', $userData[5]);

						session()->forget('userDetails');

						return "HELP LINE LOGGED";
					}
					return 'Process Failed';
				}

				$login = new \GuzzleHttp\Client();
				$res = $login->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid='.$usrTID.'&userid='.$usr->email.'&password='.$encryptedPassword.'&src=WEB');
				if ($res->getStatusCode() == 200) {
					$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
					$fileContents = trim(str_replace('"', "'", $fileContents));
					$simpleXml = simplexml_load_string($fileContents);
					$json = json_encode($simpleXml);
					$phpArray = json_decode($json, true);

					Log::info('TAMS LOGIN OTP RESPONSE', [$phpArray]);
					// dd($phpArray['tran']['sendOTP']);

					$userDetails = [
						'email' => $usr->email,
						'encPassword' => $encryptedPassword,
						'tid' => $usrTID,
						'otp' => $phpArray['tran']['sendOTP']
					];

					$userDetails =  json_encode($userDetails);

					\Log::info("Json User Details" . print_r($userDetails, true));

					$usr->session()->put('userDetails', $userDetails);

					$usr->session()->put('otpTrialCount', 0);

					$usr->session()->put('otpGeneratedAt', date("Y-m-d H:i:s", time()));

					return "success";

				}

			}
		}

	}



	public function flushAuthUser(){

		\Session::flush();

		return redirect('/');
	}

	// public function purchaseAirtime(Request $purchase){
	// 	$keyClr = hex2bin($purchase->session()->get('usrKeyPass'));
	// 	$pin = hash('SHA256', $keyClr.$purchase->pin);

	// 	//dd($pin);
	// 	$amount = (int) $purchase->amount;
	// 	if(!is_integer($amount) || $amount <= 0){
	// 		return "Cannot Process this Transaction";
	// 	}

	// 	$topupdata = "action=TAMS_WEBAPI&op=EXCHANGE&termid=".$purchase->session()->get('curAcc')."&";
	// 	$topupdata .= "userid=".$purchase->session()->get('curEm')."&pin=".$pin."&amount=".$purchase->amount."&";
	// 	$topupdata .= "phoneno=".$purchase->phone."&network=".$purchase->network."&";
	// 	$topupdata .= "convenience=";

	// 	$login = new \GuzzleHttp\Client();
	// 	$res = $login->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?'.$topupdata);
	// 	if ($res->getStatusCode() == 200) {

	// 		$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
	// 		$fileContents = trim(str_replace('"', "'", $fileContents));
	// 		$simpleXml = simplexml_load_string($fileContents);
	// 		$json = json_encode($simpleXml);
	// 		$phpArray = json_decode($json, true);

	// 		/*print_r($phpArray);
	// 		exit();*/

	// 		if ($phpArray['tran']['result'] != 0 || $phpArray['tran']['result'] != "0") {
	// 			return $phpArray['tran']['message'];
	// 		}else{
	// 			return 'success';
	// 		}
	// 	}
	// }

	public function purchaseAirtime(Request $request){
		$params = $request->all();
		// \Log::info("params". print_r($params, true));
		$sessionKey = $this->sessionKey($request);
		$clientReference = $this->helper->uniqueClientReference($request);

		$userPin = $params['pin'];
		
		if($params['network'] == "AIRT"){
			$service = "airtelvtu";
		}
		if($params['network'] == "MTN"){
			$service = "mtnvtu";
		}
		if($params['network'] == "ETST"){
			$service = "9mobilevtu";
		}
		if($params['network'] == "GLOVTU"){
			$service = "glovtu";
		}

		$pinResponse = $this->vasOperations->getEncryptedPin(session('curAcc'), session('curEm'), session('clearPass'), $params['pin']);

		if($pinResponse['responseCode'] == "00"){
			$pin = $pinResponse['data']['pin'];
		}else{
			return $pinResponse['message'];
		}

        $jsonParams = [		
			"paymentMethod" => "cash",
			"amount" => $params['amount'],
			"phone" => $params['phone'],
			"service" => $service,
			"pin" => $pin,
			"clientReference" => $clientReference,
            "channel" => "WEB",
        ];

        $headers = $this->vasOperations->getVasHeaders($jsonParams);

        \Log::info("VTU Params being sent to Vas 4.0: ". print_r($jsonParams, true));

        try {

            $response = $this->client->request('POST', $this->vasOperations->vasUrl.'/v1/vas/vtu/purchase', [
                'json' => $jsonParams,
                'headers' => $headers
            ]);

            $responseData = $this->responseToArray($response);            
			\Log::info("VTU Payment Response: ". print_r($responseData, true));
			
			if($responseData['responseCode'] == "00"){
				return 'success';
			}else{
				return $responseData['message'];
			}

        } catch (\Exception | RequestException $e) {
			\Log::info("VTU Payment Exception ". $e->getMessage());
			$requeryResponse =  $this->vasOperations->requeryTransaction($clientReference);
			if($requeryResponse['responseCode'] == "00"){
                \Log::info($jsonParams['service']." Successful Rerquery". print_r($requeryResponse, true));
                return 'success';
           }else{
				if ($e->hasResponse()) {
					$exceptionDetails = [
						'message' => $e->getMessage(),
						'file' => basename($e->getFile()),
						'line' => $e->getLine(),
						'type' => class_basename($e),
						'body' => $e->getResponse()->getBody()->getContents()
					];

					\Log::info("Vtu Payment Exception: ". print_r($exceptionDetails, true));
					$body = json_decode($exceptionDetails['body'], true);
					return $body['message'];
				}
				\Log::info("VTU Payment Exception". $e->getMessage());
                return 'An Exception occurred, Please contact Itex';
			}
        }
	}


	public function getAirtime(Request $request){
		$history = new \GuzzleHttp\Client();
		$clientHistory = $history->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=RECORDS&termid='.\Session::get('curAcc').'&userid='.\Session::get('curEm'));
		if ($clientHistory->getStatusCode() == 200) {
			$cltContents = str_replace(array("\n", "\r", "\t"), '', $clientHistory->getBody()->getContents());
			$cltContents = trim(str_replace('"', "'", $cltContents));
			$cltXml = simplexml_load_string($cltContents);
			$jsonClt = json_encode($cltXml);
			$cltArray = json_decode($jsonClt, true);

			$getHistory = $cltArray;
		}
		$block = explode("*", $getHistory['tran']['message']);

		$filter = array_filter($block, function($var){return $var !== ''; } );
		$filter = array_chunk($filter, 5)[0]; // Get Only last 5 Transactions

		// $userDetails = $this-> getUserDetails($request);
		// $startDate = date('Y-m-d', strtotime('-20 days'));
		// $endDate = date('Y-m-d');
		// $jsonParams = [
		// 	"wallet" => $userDetails['wallet_id'],
		// 	"viewWallet" => $userDetails['wallet_id'],
		// 	"username" => $userDetails['email'],
		// 	"password" => $userDetails['password'],
		// 	"product" => "ALL",
		// 	"productName" => "ALL",
		// 	"startDate" => $startDate,
		// 	"endDates" => $endDate,
		// 	"limit" => 20,
		// 	"currentPage" => 1
		// ];

		// $response = $this->guzzleClient()->request('POST', HttpRequests::baseURI().'/api/account/transaction-history', [
		// 	'json' => $jsonParams,
		// 	'headers' => HttpRequests::httpHeaders()
		// ]);
		// $responseData = $this->responseToArray($response);

		// dd($responseData, $filter);

		$data['UserDetails'] = $this->getUserDetails($request);
		$walletId = $data['UserDetails']['wallet_id'];
		$userEmail = $data['UserDetails']['email'];
		// Get Wallet Balance Details
		$balanceDetails = Account::balance($walletId, $userEmail);
		$balanceDetails = (array) $balanceDetails;
		$data['balance'] = number_format($balanceDetails['balance']);
		$data['commissionBalance'] = number_format($balanceDetails['commission']);
		$data['hist'] = $filter;
		return view('airtime',$data);

	}

	public function getData(Request $request){
		$data['UserDetails'] = $this->getUserDetails($request);
		$walletId = $data['UserDetails']['wallet_id'];
		$userEmail = $data['UserDetails']['email'];
		// Get Wallet Balance Details
		$balanceDetails = Account::balance($walletId, $userEmail);
		$balanceDetails = (array) $balanceDetails;
		$data['balance'] = number_format($balanceDetails['balance']);
		$data['commissionBalance'] = number_format($balanceDetails['commission']);

		return view('data',$data);
	}

	
	public function getWallet(Request $request){
		$history = new \GuzzleHttp\Client();
		$clientHistory = $history->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=RECORDS&termid='.\Session::get('curAcc').'&userid='.\Session::get('curEm'));
		if ($clientHistory->getStatusCode() == 200) {
			$cltContents = str_replace(array("\n", "\r", "\t"), '', $clientHistory->getBody()->getContents());
			$cltContents = trim(str_replace('"', "'", $cltContents));
			$cltXml = simplexml_load_string($cltContents);
			$jsonClt = json_encode($cltXml);
			$cltArray = json_decode($jsonClt, true);

			$getHistory = $cltArray;
		}

		$block = explode("*", $getHistory['tran']['message']);

		$filter1 = array_filter($block, function($var){return $var !== ''; } );

		$data['UserDetails'] = $this->getUserDetails($request);
		$walletId = $data['UserDetails']['wallet_id'];
		$userEmail = $data['UserDetails']['email'];
		// Get Wallet Balance Details
		$balanceDetails = Account::balance($walletId, $userEmail);
		$balanceDetails = (array) $balanceDetails;
		$data['balance'] = number_format($balanceDetails['balance']);
		$data['commissionBalance'] = number_format($balanceDetails['commission']);
		$data['hist'] = $filter1;

		return view('account',$data);
	}
	//PAY BILL
	public function getPayBills(Request $request){
		$data['UserDetails'] = $this->getUserDetails($request);
		$walletId = $data['UserDetails']['wallet_id'];
		$userEmail = $data['UserDetails']['email'];
		// Get Wallet Balance Details
		$balanceDetails = Account::balance($walletId, $userEmail);
		$balanceDetails = (array) $balanceDetails;
		$data['balance'] = number_format($balanceDetails['balance']);
		$data['commissionBalance'] = number_format($balanceDetails['commission']);
		$URI= 'paybills';
		return view($URI)->with($data);

	}

		//HISTORY
	public function getTrHistory(){

		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=BALANCE&termid='.\Session::get('curAcc').'&userid='.\Session::get('curEm'));
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);

			$getBalance = $phpArray;
		}


		$history = new \GuzzleHttp\Client();
		$clientHistory = $history->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=RECORDS&termid='.\Session::get('curAcc').'&userid='.\Session::get('curEm'));
		if ($clientHistory->getStatusCode() == 200) {
			$cltContents = str_replace(array("\n", "\r", "\t"), '', $clientHistory->getBody()->getContents());
			$cltContents = trim(str_replace('"', "'", $cltContents));
			$cltXml = simplexml_load_string($cltContents);
			$jsonClt = json_encode($cltXml);
			$cltArray = json_decode($jsonClt, true);

			$getHistory = $cltArray;
		}

		$block = explode("*", $getHistory['tran']['message']);

		$filter = array_filter($block, function($var){return $var !== ''; } );

		/*print_r($filter);
		exit();*/
		$balance = explode('N', $phpArray['tran']['balance']);
		return view('trhistory', ['balance' => $balance[1], 'hist' => $filter]);

	}



			//HISTORY API FOR PAYVICE MOBILE
	public function getTrHistoryForMobile($tid, $useremail){

		/*$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=BALANCE&termid='.$tid.'&userid='.$useremail;
			if ($res->getStatusCode() == 200) {
				$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
				$fileContents = trim(str_replace('"', "'", $fileContents));
				$simpleXml = simplexml_load_string($fileContents);
				$json = json_encode($simpleXml);
				$phpArray = json_decode($json, true);

				$getBalance = $phpArray;
			}*/


			$history = new \GuzzleHttp\Client();
			$clientHistory = $history->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=RECORDS&termid='.$tid.'&userid='.$useremail);
			if ($clientHistory->getStatusCode() == 200) {
				$cltContents = str_replace(array("\n", "\r", "\t"), '', $clientHistory->getBody()->getContents());
				$cltContents = trim(str_replace('"', "'", $cltContents));
				$cltXml = simplexml_load_string($cltContents);
				$jsonClt = json_encode($cltXml);
				$cltArray = json_decode($jsonClt, true);

				$getHistory = $cltArray;
			}

			$block = explode("*", $getHistory['tran']['message']);
			$filter = array_filter($block, function($var){return $var !== ''; } );

			$jsonResponse = [];
			foreach ($filter as $value) {
				if (substr_count($value, '|') <= 7) {
					$val = explode('|', $expl);

					$finalArray['amount'] = $val[1];
					$finalArray['type'] = $val[0];
					$finalArray['service'] = $val[2];
					$finalArray['beneficiary'] = $val[6];
					$finalArray['ref'] = $val[5];
					$finalArray['date'] = $val[7];
				}else{
					$val = explode($value, '|');

					$finalArray['amount'] = $val[1];
					$finalArray['type'] = $val[0];
					$finalArray['service'] = $val[2];
					$finalArray['beneficiary'] = $val[6];
					$finalArray['ref'] = $val[5];
					$finalArray['date'] = $val[7];
					$finalArray['status'] = $val[8];
				}
			}


			return json_encode($jsonResponse);

		}

		//SETTINGS
		public function getUserSettings(Request $request){
			$data['UserDetails'] = $this->getUserDetails($request);
			$walletId = $data['UserDetails']['wallet_id'];
			$userEmail = $data['UserDetails']['email'];
			// Get Wallet Balance Details
			$balanceDetails = Account::balance($walletId, $userEmail);
			$balanceDetails = (array) $balanceDetails;
			$data['balance'] = number_format($balanceDetails['balance']);
			$data['commissionBalance'] = number_format($balanceDetails['commission']);
			return view('settings',$data);

		}

<<<<<<< HEAD
=======
		public function getSupport(Request $request){
			$data['UserDetails'] = $this->getUserDetails($request);
			$walletId = $data['UserDetails']['wallet_id'];
			$userEmail = $data['UserDetails']['email'];
			// Get Wallet Balance Details
			$balanceDetails = Account::balance($walletId, $userEmail);
			$balanceDetails = (array) $balanceDetails;
			$data['balance'] = number_format($balanceDetails['balance']);
			$data['commissionBalance'] = number_format($balanceDetails['commission']);
			return view('support',$data);

		}

>>>>>>> cb07576dd8260ccd0360d8a936eecad35aac01ef
		public function PTMLtoITEX(Request $request){

			$data = json_decode($request->getContent(), true);

	/*


	BlNumber
	TypeBL
	TypeInvoice
	DateRate
	DateTransaction
	NumberPos
	Total
	ID
	Token
	Service
		*/

	if (count($data) < 9) {
		return response()->json(['status' => 0, 'message' => 'Unauthorized API call']);
	}

	$getToken = Vice::where('token', $data['Token'])->where('vice_id', $data['APIID'])->first();
	//count($getToken) > 0
	if ($data["Token"] == "1c2c538a14942d4fd6c5d36fce07544d850246e2e64d8cf32a3c25250037d1c1" || $data["Token"] == "1c2c528a14942d4fd6c5d36fce07544d850246e2e64d8cf32a3c25250037d1c2" || $data["Token"] == "1c3c538a14942d4fd6c5d36fce07544d850216e2e64d8cf32a3c25250037d1c1" || $data["Token"] == "1c3c538a14942d4fd2c5d36fce07523d850216e2e64d8cf32a3c25250037d1c1" || $data["Token"] == "1c3c538a14940d4fd6c5d36fce07544d850456e2e64d8cf32a3c25250037d1c1" || $data["Token"] == "1c3c538a14380d4fd6c5d36fce02224d850456e2e64d8cf32a3c25950037d1c1" || $data["Token"] == "1c3c538a14380d4fd6c5d36fce07544d850456e2e64d8cf32a3c25950037d1c1") {

		if ($data['Service'] != "PTML"){
			return response()->json(['status' => 0, 'message' => 'Unauthorized Service. Token allowed for PTML only']);

		}

		/*START*/

		/*INIT*/
		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/tams/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&termID=203301ZA&BlNumber='.$data['BlNumber'].'&TypeBL='.$data['TypeBL'].'&TypeInvoice='.$data['TypeInvoice'].'&DateRate='.$data['DateRate'].'&DateTransaction='.$data['DateTransaction'].'&NumberPos='.$data['NumberPos'].'&Total='.$data['Total'].'&APIID='.$data['APIID'].'&PosIP='.$data['PosIP'].'&Port='.$data['Port'].'&control=PTML');
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);

			 //print_r($phpArray);
			 //exit();


			if ($phpArray['efttran']['result'] == 0) {
				return response()->json(['status' => 0, 'message' => str_replace("\"", "'",$phpArray['efttran']['message'])]);
			}else if($phpArray['efttran']['result'] == 'E'){
				return response()->json(['status' => 0, 'message' => str_replace("\"", "'",$phpArray['efttran']['message'])]);
			}


			if ($phpArray['efttran']['result'] == 2) {
				return response()->json(['status' => "2", 'message' => 'Failed. Please check your Connection']);
			}
		}
		/*END*/
	}else{
		return response()->json(['status' => "2", 'message' => 'Failed. Please check your token/Vice ID']);
	}



}


public function resetTransPin(){
	$details['username'] = session()->get('curUsr');
	$details['wallet_id'] = session()->get('curAcc');
	$details['email'] = session()->get('curEm');
	$details['password'] = session()->get('usrKeyPass');

	$data['UserDetails'] = $details;

	$walletId = $data['UserDetails']['wallet_id'];
	$userEmail = $data['UserDetails']['email'];
	// Get Wallet Balance Details
	$balanceDetails = Account::balance($walletId, $userEmail);
	$balanceDetails = (array) $balanceDetails;
	$data['balance'] = number_format($balanceDetails['balance']);
	$data['commissionBalance'] = number_format($balanceDetails['commission']);
	$data['resetPinError'] = true;


	$url = 'https://payvice.itexapp.com/v1/auth/resetPin';
	$header = ['Content-Type' => 'application/json'];

	$payload = [
		'channel' => "web",
		'email' => $details['email']
	];

	$payloadData = [
		'json' => $payload,
		'headers' => $header,
	];

	$client = new \GuzzleHttp\Client([
		'verify' => false,
	]);

	$passwordChanged = false;
	
	if(session('PASSWORD_CHANGED') === 'changed'){
		$passwordChanged = true;
	}
	session()->forget('PASSWORD_CHANGED');
	
	try {
		$response = $client->request('POST', $url, $payloadData);
		return $response->getStatusCode() === 200 ? view('changePassword')->with(['passwordChanged' => $passwordChanged]) : view('settings', $data);
	} catch (\Throwable $th) {
		return view('settings', $data);
	}
}

public function newTransPin(Request $request){
	$validator = Validator::make($request->all(), [
		'phone' => 'required|numeric',
		'password' => 'required|string',
		'pin' => 'required|numeric|confirmed',
		'resetCode' => 'required|string',
	]);

	if ($validator->fails()) {
		return view('changePassword')
		->withErrors($validator);
	}
	
	$url = 'https://payvice.itexapp.com/v1/auth/completePinReset';
	$randHexStr = implode( array_map( function() { return dechex( mt_rand( 0, 15 ) ); }, array_fill( 0, 16, null ) ) );
	$key = '3A56745C8CC617398AACAE7D66BACDE7';
	$cipher = 'aes-256-cbc';
	$iv = $randHexStr;
	$encryptedPassword = openssl_encrypt($request->password, $cipher, $key, $options=0, $iv);
	$encryptedPin = openssl_encrypt($request->pin, $cipher, $key, $options=0, $iv);

	$header = ['Content-Type' => 'application/json', 'sysid' => $randHexStr ];

	$payload = [
		'channel' => "web",
		'pin' => $encryptedPin,
		'password' => $encryptedPassword,
		'email' => session()->get('curEm'),
		'mobile' => $request->phone,
		'userTID' => session()->get('curAcc'),
		'resetCode' => $request->resetCode,
	];

	$payloadData = [
		'json' => $payload,
		'headers' => $header,
	];

	$client = new \GuzzleHttp\Client([
		'verify' => false,
	]);

	$passwordChanged = false;

	try {
		$response = $client->request('POST', $url, $payloadData);
		return $response->getStatusCode() === 200 ? view('changePassword', ['responseSuccess' => true, 'passwordChanged' => $passwordChanged]) : view('changePassword', ['responseError' => 'An error occurred, Please try Again', 'passwordChanged' => $passwordChanged]);
	} catch (\Throwable  $exception) {
		$responseBody = $exception->getResponse()->getBody()->getContents();
		return view('changePassword', ['responseError' => $responseBody]);
	}
}



public function processApiCall(Request $request){

	$data = json_decode($request->getContent(), true);

	/* vice_id = terminal
	 * user_name = username
	 * amount = amount
	 * phone = phone number
	 * service = network
	 * auth = transaction PIN
	 * token = env('VICE_KEY')
	 * pwd = base64_encode(4831!password) //where password is user password
	*/

	if (count($data) < 7)
		return response()->json(['status' => 0, 'message' => 'Unauthorized API call']);
	if ($data['token'] != env('VICE_KEY'))
		return response()->json(['status' => 0, 'message' => 'Unauthorized API call']);



	/*INIT*/
	$client = new \GuzzleHttp\Client();
	$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$data['user_name'].'&control=INIT');
	if ($res->getStatusCode() == 200) {
		$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
		$fileContents = trim(str_replace('"', "'", $fileContents));
		$simpleXml = simplexml_load_string($fileContents);
		$json = json_encode($simpleXml);
		$phpArray = json_decode($json, true);

			/*print_r($phpArray);
			exit();*/


			if ($phpArray['tran']['result'] == 1) {
				return $phpArray['tran']['message'];
			}else{
				$usrTID = $data['vice_id'];
				$getKey = explode('|', $phpArray['tran']['message']);
				$key = $getKey[1];

				$tidArray = str_split($usrTID);
				$createClrKey = "";

				foreach ($tidArray as $tidChar) {
					if (!is_numeric($tidChar))
						$tidChar = 7;
					$createClrKey .= substr($key, $tidChar, 1);

				}

				$getUsrPass = str_replace('4831!', '', base64_decode($data['pwd']));

				$hex = hex2bin($createClrKey);
				$pass = $hex.$getUsrPass;


				$encryptedPassword = hash('SHA256', $pass);

				//$request->session()->put('usrKeyPass', $encryptedPassword);

				/*echo $encryptedPassword.'<br> >>>>>'.$createClrKey;
				exit();*/

				$login = new \GuzzleHttp\Client();
				$res = $login->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid='.$usrTID.'&userid='.$data['user_name'].'&password='.$encryptedPassword);
				if ($res->getStatusCode() == 200) {
					$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
					$fileContents = trim(str_replace('"', "'", $fileContents));
					$simpleXml = simplexml_load_string($fileContents);
					$json = json_encode($simpleXml);
					$phpArray = json_decode($json, true);


					if ($phpArray['tran']['result'] == 1)
						return $phpArray['tran']['message'];

					$userData = explode("|", $phpArray['tran']['message']);

					$userCredentials = [
						'email' => $userData[5],
						'name' =>  $userData[0],
						'account' => $userData[2]
					];

					$name = explode('<macros>', $userData[0]);

					/*$request->session()->put('curUsr', $name[0]);
					$request->session()->put('curAcc', $userData[2]);
					$request->session()->put('curEm', $userData[5]);
*/
					$keyClr = hex2bin($encryptedPassword);
					$pin = hash('SHA256', $keyClr.$data['auth']);

					$topupdata = "action=TAMS_WEBAPI&op=EXCHANGE&termid=".$data['vice_id']."&";
					$topupdata .= "userid=".$data['user_name']."&pin=".$pin."&amount=".$data['amount']."&";
					$topupdata .= "phoneno=".$data['phone']."&network=".$data['service']."&";
					$topupdata .= "convenience=";

					$login = new \GuzzleHttp\Client();
					$res = $login->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?'.$topupdata);
					if ($res->getStatusCode() == 200) {

						$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
						$fileContents = trim(str_replace('"', "'", $fileContents));
						$simpleXml = simplexml_load_string($fileContents);
						$json = json_encode($simpleXml);
						$phpArray = json_decode($json, true);

						if ($phpArray['tran']['result'] == 0) {
							return response()->json(
								[
									"message" => "Topup completed successfully",
									"status" => 1,
									"result" => "success"
								]
							);
						}else{
							return response()->json(
								[
									"message" => $phpArray['tran']['message'],
									"status" => 0,
									"result" => "failed"
								]
							);

						}
					}

				}

			}
		}




	}


	/*INITIATE LOOKUP CALL - FOR VISIONTEK API CALL*/
	public function lookup(Request $req){
		$data = json_decode($req->getContent(), true);
		/*INIT*/
		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$data['user_name'].'&control=INIT');
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);

			/*print_r($phpArray);
			exit();*/


			if ($phpArray['tran']['result'] == 1) {

				return response()->json(['status' => 0, 'message' => 'Invalid credentials']);

			}else{

				$usrTID = $phpArray['tran']['macros_tid'];
				$clr = env('V_TEK');
				$hash = hash('SHA256', $usrTID.$clr.date('Y-m-d H:i'));

				if ($usrTID != $data['vice_id']) {
					return response()->json(['status' => 0, 'message' => 'Unknown vice ID']);
				}else{

					if (Vice::where('vice_id', $usrTID)->exists()) {

						if (Vice::where('vice_id', $usrTID)->update(['token' => $hash, 'created_at' => date('Y-m-d H:i:s', time()), 'status' => 0])) {
							return response()->json([
								'vice_id' => $usrTID,
								'token' => $hash,
								'status' => 0,
								'message' => 'Authenticated successfully'
							]);
						}

					}else{

						$vice = new Vice;
						$vice->token = $hash;
						$vice->vice_id = $usrTID;
						$vice->status = 0;

						if ($vice->save()) {
							return response()->json([
								'vice_id' => $usrTID,
								'token' => $hash,
								'status' => 1,
								'message' => 'Authenticated successfully'
							]);
						}
					}


				}


			}


		}
	}


	/*VISIONTEK - API CALL*/
	public function processApiCallVisionTek(Request $request){


		/*return response()->json(['status' => 0, 'message' => 'API service blocked']);
		exit();*/

		$data = json_decode($request->getContent(), true);

		/*return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token already used']);
		exit();*/

	/* vice_id = terminal
	 * user_name = username
	 * amount = amount
	 * phone = phone number
	 * service = network
	 * auth = transaction PIN
	 * token = env('VICE_KEY')
	 * pwd = base64_encode(4831!password) //where password is user password
	*/

	if (count($data) < 7) {
		return response()->json(['status' => 0, 'message' => 'Unauthorized API call']);
	}

	$getToken = Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->first();

	if ($getToken) {
		if (Payvice::tokenExpiration($getToken->created_at) == true){
			//Payvice::timeAgo(strtotime($getToken->created_at)) >= 2
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token expired']);
		}

		if ($getToken->status == 1) {
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token already used']);
		}


		if ($data['service'] != "MTNVTU"){
			return response()->json(['status' => 0, 'message' => 'Unauthorized Service. Token allowed for MTN only']);

		}

		/*START*/

		/*INIT*/
		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$data['user_name'].'&control=INIT');
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);

			/*print_r($phpArray);
			exit();*/


			if ($phpArray['tran']['result'] == 1) {
				return response()->json(['status' => 0, 'message' => $phpArray['tran']['message']]);
			}else if($phpArray['tran']['result'] == 'E'){
				return response()->json(['status' => 0, 'message' => $phpArray['tran']['message']]);
			}else{
				$usrTID = $data['vice_id'];
				$getKey = explode('|', $phpArray['tran']['message']);
				$key = $getKey[1];

				$tidArray = str_split($usrTID);
				$createClrKey = "";

				foreach ($tidArray as $tidChar) {
					if (!is_numeric($tidChar))
						$tidChar = 7;
					$createClrKey .= substr($key, $tidChar, 1);

				}

				$getUsrPass = $data['pwd'];

				$hex = hex2bin($createClrKey);
				$pass = $hex.$getUsrPass;


				$encryptedPassword = hash('SHA256', $pass);

				//$request->session()->put('usrKeyPass', $encryptedPassword);

				/*echo $encryptedPassword.'<br> >>>>>'.$createClrKey;
				exit();*/

				$login = new \GuzzleHttp\Client();
				$res = $login->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid='.$usrTID.'&userid='.$data['user_name'].'&password='.$encryptedPassword);
				if ($res->getStatusCode() == 200) {
					$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
					$fileContents = trim(str_replace('"', "'", $fileContents));
					$simpleXml = simplexml_load_string($fileContents);
					$json = json_encode($simpleXml);
					$phpArray = json_decode($json, true);


					if ($phpArray['tran']['result'] == 1){
						return response()->json(['status' => 0, 'message' => $phpArray['tran']['message']]);
					}


					$userData = explode("|", $phpArray['tran']['message']);

					$userCredentials = [
						'email' => $userData[5],
						'name' =>  $userData[0],
						'account' => $userData[2]
					];

					$name = explode('<macros>', $userData[0]);

					/*$request->session()->put('curUsr', $name[0]);
					$request->session()->put('curAcc', $userData[2]);
					$request->session()->put('curEm', $userData[5]);
*/


					$data['service'] = "MTNVTUSONITE";

					$keyClr = hex2bin($encryptedPassword);
					$pin = hash('SHA256', $keyClr.$data['auth']);

					$topupdata = "action=TAMS_WEBAPI&op=EXCHANGE&termid=".$data['vice_id']."&";
					$topupdata .= "userid=".$data['user_name']."&pin=".$pin."&amount=".$data['amount']."&";
					$topupdata .= "phoneno=".$data['phone']."&network=".$data['service']."&";
					$topupdata .= "convenience=";

					$login = new \GuzzleHttp\Client();
					$res = $login->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?'.$topupdata);
					if ($res->getStatusCode() == 200) {

						$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
						$fileContents = trim(str_replace('"', "'", $fileContents));
						$simpleXml = simplexml_load_string($fileContents);
						$json = json_encode($simpleXml);
						$phpArray = json_decode($json, true);

						if ($phpArray['tran']['result'] == "0") {

							Vice::where('vice_id', $usrTID)->where('token', $data['token'])->update(['status' => 1]);
							$txnRef = uniqid();

							$txn = ['token' => $data['token'], 'vice' => $data['vice_id'], 'ref' => $txnRef, 'status' => 1, 'tran_ben' => $data['phone'], 'tran_amount' => $data['amount']];
							Transaction::create($txn);
							return response()->json(
								[
									"message" => "Topup completed successfully",
									"status" => 1,
									"date" => date('d/m/Y H:i:s', time()),
									"txn_ref" => $txnRef
								]
							);
						}else{
							$txnRef = uniqid();
							Vice::where('vice_id', $usrTID)->where('token', $data['token'])->update(['status' => 1]);
							$txn = ['token' => $data['token'], 'vice' => $data['vice_id'], 'ref' => $txnRef, 'status' => 0, 'tran_ben' => $data['phone'], 'tran_amount' => $data['amount']];
							Transaction::create($txn);
							return response()->json(
								[
									"message" => $phpArray['tran']['message'],
									"status" => 0,
									"date" => date('d/m/Y H:i:s', time()),
									"txn_ref" => $txnRef
								]
							);

						}
					}

				}

			}
		}
		/*END*/
	}else{
		return response()->json(['status' => 0, 'message' => 'Failed. Please check your token/Vice ID']);
	}



}


/*
* Requery previous request
*/
public function requeryTxn(Request $req){
	$data = json_decode($req->getContent(), true);
	$stat = "";
	$msg = "";
	$iePayer = "";
	$ieToken = "";
	$ieAddress = "";
	$status = Transaction::where('token', $data['token'])->where('vice', $data['vice_id'])->first();

	if ($status) {
		if ($status->status == "1" && $status->tran_type != "EKEDC") {
			$stat = "approved";
			$msg = "Transaction was successful";
		}else if($status->status == "1" && $status->tran_type == "EKEDC"){
			$stat = "approved";
			$msg = "Transaction was successful";
		}else{
			$stat = "declined";
		}

		if ($status->tran_type == 'ie' or $status->tran_type == 'EKEDC') {
			$ieToken = $status->ie_token;
			$ieAddress = $status->payer_address;
			$iePayer = $status->payer_name;
		}else{
			$ieToken = null;
			$ieAddress = $status->payer_address;
			$iePayer = $status->payer_name;
		}

		if ($status->tran_type == 'ie' or $status->tran_type == 'EKEDC') {
			return response()->json([
				'status' => 1,
				'txn_status' => $stat,
				'txn_date' => date('d/m/Y H:i:s', strtotime($status->created_at)),
				'vice_id' => $status->vice,
				'txn_token' => $status->token,
				'amount' => $status->tran_amount,
				'beneficiary' => $status->tran_ben,
				'date' => date('d/m/Y H:i:s', time()),
				'electricity' => [
					'token_value' => $ieToken,
					'address' => $ieAddress,
					'payer' => $iePayer
				]
			]);
		}else{
			return response()->json([
				'status' => 1,
				'txn_status' => $stat,
				'txn_date' => date('d/m/Y H:i:s', strtotime($status->created_at)),
				'vice_id' => $status->vice,
				'txn_token' => $status->token,
				'amount' => $status->tran_amount,
				'beneficiary' => $status->tran_ben,
				'date' => date('d/m/Y H:i:s', time())
			]);
		}
	}else{
		return response()->json([
			'status' => 0,
			'date' => date('d/m/Y H:i:s', time()),
			'message' => "Invalid token/vice id"
		]);
	}


}


public function ikedcAgent(Request $ie){
	$data = json_decode($ie->getContent(), true);
	/*print_r($data);
	exit();*/

	/*INIT*/
	$client = new \GuzzleHttp\Client();
	$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$data['vice_id'].'&control=INIT');
	if ($res->getStatusCode() == 200) {
		$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
		$fileContents = trim(str_replace('"', "'", $fileContents));
		$simpleXml = simplexml_load_string($fileContents);
		$json = json_encode($simpleXml);
		$phpArray = json_decode($json, true);

		$usrTID = $phpArray['tran']['macros_tid'];

		if ($phpArray['tran']['result'] == "1") {
			return json_encode(['auth' => "1", 'message' => $phpArray['tran']['message']]);
		}else if($usrTID != $data['vice_tid']){
			return json_encode(['auth' => "1", 'message' => $phpArray['tran']['message']]);
		}else{
			$usrTID = $data['vice_tid'];
			$getKey = explode('|', $phpArray['tran']['message']);
			$key = $getKey[1];
			$tidArray = str_split($usrTID);
			$createClrKey = "";

			foreach ($tidArray as $tidChar) {
				if (!is_numeric($tidChar))
					$tidChar = 7;
				$createClrKey .= substr($key, $tidChar, 1);

			}

			$hex = hex2bin($createClrKey);
			$pass = $hex.$data['vice_pwd'];


			$encryptedPassword = hash('SHA256', $pass);

			$login = new \GuzzleHttp\Client();
			$res = $login->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid='.$usrTID.'&userid='.$data['vice_id'].'&password='.$encryptedPassword);
			if ($res->getStatusCode() == 200) {
				$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
				$fileContents = trim(str_replace('"', "'", $fileContents));
				$simpleXml = simplexml_load_string($fileContents);
				$json = json_encode($simpleXml);
				$phpArray = json_decode($json, true);

				if ($phpArray['tran']['result'] == "1"){
					return json_encode(['auth' => "1", 'message' => $phpArray['tran']['message']]);
				}else{

					$post = ['tid' => $data['vice_tid']];
					$client = new \GuzzleHttp\Client();
					$res = $client->post('http://197.253.19.75/tams/eftpos/op/agent_get_balance.php', ['json' => $post]);
					if ($res->getStatusCode() == 200) {
						print_r($res->getBody()->getContents());
					}

				}

			}

		}
	}


}



/*UPDATE AGENT WALLET AFTER IKEDC*/

public function lowerAgentWallet(Request $req){
	$data = json_decode($req->getContent(), true);
	$client = new \GuzzleHttp\Client();
		//print_r($data);
	$res = $client->post('http://197.253.19.75/tams/eftpos/op/bal_update.php', ['json' => $data]);
		/*if ($res->getStatusCode() == 200) {
			print_r($res->getBody()->getContents());
		}*/
	}


	/*TEST TRANSACTION*/
	public function ikedcAgentTest(Request $ie){
		$data = json_decode($ie->getContent(), true);
		/*INIT*/
		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.78/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$data['vice_id'].'&control=INIT');
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);

			/*print_r($phpArray);
			exit();*/

			$usrTID = $phpArray['tran']['macros_tid'];

			if ($phpArray['tran']['result'] == 1) {
				return json_encode(['auth' => "1", 'message' => $phpArray['tran']['message']]);
			}else if($usrTID != $data['vice_tid']){
				return json_encode(['auth' => "1", 'message' => $phpArray['tran']['message']]);
			}else{
				$usrTID = $data['vice_tid'];
				//$phpArray['tran']['macros_tid'];
				$getKey = explode('|', $phpArray['tran']['message']);
				$key = $getKey[1];
				$tidArray = str_split($usrTID);
				$createClrKey = "";

				foreach ($tidArray as $tidChar) {
					if (!is_numeric($tidChar))
						$tidChar = 7;
					$createClrKey .= substr($key, $tidChar, 1);

				}

				$hex = hex2bin($createClrKey);
				$pass = $hex.$data['vice_pwd'];


				$encryptedPassword = hash('SHA256', $pass);

				$login = new \GuzzleHttp\Client();
				$res = $login->post('http://197.253.19.78/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid='.$usrTID.'&userid='.$data['vice_id'].'&password='.$encryptedPassword);
				if ($res->getStatusCode() == 200) {
					$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
					$fileContents = trim(str_replace('"', "'", $fileContents));
					$simpleXml = simplexml_load_string($fileContents);
					$json = json_encode($simpleXml);
					$phpArray = json_decode($json, true);

					/*print_r($phpArray);
					exit();*/

					if ($phpArray['tran']['result'] == 1){
						return json_encode(['auth' => "1", 'message' => $phpArray['tran']['message']]);
					}else{

						$post = ['tid' => $data['vice_tid']];
						$client = new \GuzzleHttp\Client();
						$res = $client->post('http://197.253.19.78/tams/eftpos/op/agent_get_balance.php', ['json' => $post]);
						if ($res->getStatusCode() == 200) {
							print_r($res->getBody()->getContents()."xxxxx");
						}

					}

				}

			}
		}


	}


	/*UPDATE AGENT WALLET AFTER IKEDC - TEST TRANSACTION*/

	public function lowerAgentWalletTest(Request $req){
		$data = json_decode($req->getContent(), true);
		$client = new \GuzzleHttp\Client();
		//print_r($data);
		$res = $client->post('http://197.253.19.78/tams/eftpos/op/bal_update.php', ['json' => $data]);
		/*if ($res->getStatusCode() == 200) {
			print_r($res->getBody()->getContents());
		}*/
	}



	/*GET AGENT TRANSACTION HISTORY*/
	public function getAgentTran(){
		$wallet = $_GET['id'];
		$email = $_GET['email'];

		$history = new \GuzzleHttp\Client();
		$clientHistory = $history->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=RECORDS&termid='.$wallet.'&userid='.$email);
		if ($clientHistory->getStatusCode() == 200) {
			$cltContents = str_replace(array("\n", "\r", "\t"), '', $clientHistory->getBody()->getContents());
			$cltContents = trim(str_replace('"', "'", $cltContents));
			$cltXml = simplexml_load_string($cltContents);
			$jsonClt = json_encode($cltXml);
			$cltArray = json_decode($jsonClt, true);

			$getHistory = $cltArray;
		}

		$block = explode("*", $getHistory['tran']['message']);

		$filter = array_filter($block, function($var){return $var !== ''; } );


		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=BALANCE&termid='.$wallet.'&userid='.$email);
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);

			$getBalance = $phpArray;
		}

		$balance = explode('N', $phpArray['tran']['balance']);

		return view('agent', ['hist' => $filter, 'bal' => $balance[1]]);
	}


	public function getAllSubAgents(){
		// $wallet = isset($_GET['id']) ? $_GET['id'] : null;

		// $history = new \GuzzleHttp\Client();
		// $clientHistory = $history->post('http://197.253.19.75/tams/eftpos/devinterface/transactionadvice.php?action=PAYVICE_SUB_AGENT&termid=203301ZA&vice_id='.$wallet);
		// if ($clientHistory->getStatusCode() == 200) {
		// 	$cltContents = str_replace(array("\n", "\r", "\t"), '', $clientHistory->getBody()->getContents());
		// 	$cltContents = trim(str_replace('"', "'", $cltContents));
		// 	$cltXml = simplexml_load_string($cltContents);
		// 	$jsonClt = json_encode($cltXml);
		// 	$cltArray = json_decode($jsonClt, true);

		// 	$ag = [];

		// 	foreach ($cltArray['efttran'] as $msg) {
		// 		$mg = json_decode($msg, true);
		// 		array_push($ag, $mg);
		// 	}

		// 	$filter = array_filter($ag, function($var){return $var !== ''; } );
		// 	return view('list-agent', ['list' => $filter]);
		// }
	}


	public function getAllTxn($wallet){
		$getTran = Transaction::where('vice',  $wallet)->orderBy('id', 'desc')->paginate(100);
		return view("tran-history", ['tran' => $getTran]);
	}


<<<<<<< HEAD
=======

>>>>>>> cb07576dd8260ccd0360d8a936eecad35aac01ef
}