<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vice;
use Payvice;
use App\Transaction;


class VasController extends Controller
{

	public function getMultiChoiceLookup(Request $request){
		//dd($request->all());
		$data = json_decode($request->getContent(), true);

		/*INIT*/
		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$data['user_name'].'&control=INIT');
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);


			if ($phpArray['tran']['result'] == 1) {
				return response()->json(['status' => 0, 'message' => $phpArray['tran']['message']]);
			}else{
				$reqContent = ['unit' => $data['service'],  'iuc' => $data['beneficiary']];
				$headers = [
					'Authorization' => env('IISYS_AUTH'),
					'sysid' => env('IISYS_BC'),
					'Content-Type' => 'application/json'
				];
				$chk = new \GuzzleHttp\Client();
				$res = $chk->post('http://197.253.19.75:8029/vas/multichoice/lookup', ['json' => $reqContent, 'headers' => $headers]);
				if ($res->getStatusCode() == 200) {

					$response = json_decode($res->getBody()->getContents(), true);
					if ($response['error'] == true) {

						return response()->json(
							[
								"message" => $response['message'],
								"status" => 0,
								"date" => date('d/m/Y H:i:s', time()),
								"txn_ref" => null
							]
						);
					}else{

						//return $response;
						return response()->json(
							[
								"message" => "Subscription plans lookup was successful",
								"status" => 1,
								"date" => date('d/m/Y H:i:s', time()),
								"plans" => $response['data']
							]
						);
					}
				}else{

					return response()->json(
						[
							"message" => "An error occured. Please contact system admin",
							"status" => 0,
							"date" => date('d/m/Y H:i:s', time()),
							"txn_ref" => null
						]
					);
				}
			}


		}

	}


	public function getMultiSubPlans(){

		$reqContent = ['unit' => $_GET['cTv'],  'iuc' => $_GET['card']];
		$headers = [
			'Authorization' => env('IISYS_AUTH'),
			'sysid' => env('IISYS_BC'),
			'Content-Type' => 'application/json'
		];
		$chk = new \GuzzleHttp\Client();
		$res = $chk->post('http://197.253.19.75:8029/vas/multichoice/lookup', ['json' => $reqContent, 'headers' => $headers]);
		if ($res->getStatusCode() == 200) {

			$response = json_decode($res->getBody()->getContents(), true);
			if ($response['error'] == true) {

				return view('sub-plans', ['error' => $response['message'], 'plans' => null]);
			}else{

				\Session::put('iuc', $_GET['card']);
				\Session::put('unit', $_GET['cTv']);

						//return $response;
				return view('sub-plans', ['plans' => $response['data'], 'error' => null]);

			}
		}else{

			return view('sub-plans', ['error' => 'Error Occured', 'plans' => null]);
		}
	}


	public function getSmileSubPlans(Request $req){
		$smileData = [
			"account" => $_GET['card'],
			"wallet" => \Session::get('curAcc'),
			"username" => \Session::get('curEm')
		];
		$custName = "";
		$postUrl = "";
		if ($_GET['payType'] === 'acc') {
			$postUrl = 'http://197.253.19.75:8029/smile/validate';
		}else if($_GET['payType'] === 'phone'){
			$postUrl = 'http://197.253.19.75:8029/smile/validate/phone';
		}
		$chk = new \GuzzleHttp\Client();
		$res = $chk->post($postUrl, ['json' => $smileData]);
		if ($res->getStatusCode() == 200) {

			$response = json_decode($res->getBody()->getContents(), true);

			if ($response['status'] === 1) {
				\Session::put('smlAcc', $_GET['card']);
				\Session::put('payMethod', $_GET['payType']);
				$smileData = [
					"wallet" => \Session::get('curAcc'),
					"username" => \Session::get('curEm')
				];

				$custName = $response['customerName'];
				$chk = new \GuzzleHttp\Client();
				$res = $chk->post('http://197.253.19.75:8029/smile/get-bundles', ['json' => $smileData]);
				if ($res->getStatusCode() == 200) {
					$response = json_decode($res->getBody()->getContents(), true);

					if ($response['status'] === 1) {
						return view('smile-plans', ['error' => null, 'plans' => $response['bundles'], 'name' => $custName]);
					}else{
						return view('smile-plans', ['error' => $response['message'], 'plans' => null, 'name' => null]);
					}
				}
			}else{
				return view('smile-plans', ['error' => $response['message'], 'plans' => null]);
			}

		}
	}


	/*VALIDATE MULTICHOICE-CUSTOMER*/
	public function getMultiChoiceAccountDetails(Request $request){
		$data = json_decode($request->getContent(), true);


		/*INIT*/
		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$data['user_name'].'&control=INIT');
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);


			if ($phpArray['tran']['result'] == 1) {
				return response()->json(['status' => 0, 'message' => $phpArray['tran']['message']]);
			}else{
				$reqContent = ['unit' => $data['service'],  'iuc' => $data['beneficiary']];
				$headers = [
					'Authorization' => env('IISYS_AUTH'),
					'sysid' => env('IISYS_BC'),
					'Content-Type' => 'application/json'
				];
				$chk = new \GuzzleHttp\Client();
				$res = $chk->post('http://197.253.19.75:8029/vas/multichoice/validate', ['json' => $reqContent, 'headers' => $headers]);
				if ($res->getStatusCode() == 200) {

					$response = json_decode($res->getBody()->getContents(), true);
					if ($response['error'] == true) {

						return response()->json(
							[
								"message" => $response['message'],
								"status" => 0,
								"date" => date('d/m/Y H:i:s', time()),
								"txn_ref" => null
							]
						);
					}else{

						unset($response['error']);
						return response()->json(
							[
								"message" => "Account validation was successful",
								"status" => 1,
								"date" => date('d/m/Y H:i:s', time()),
								"customer" => $response
							]
						);
					}
				}else{

					return response()->json(
						[
							"message" => "An error occured. Please contact system admin",
							"status" => 0,
							"date" => date('d/m/Y H:i:s', time()),
							"txn_ref" => null
						]
					);
				}
			}
		}

	}



	/*PROCESS PAYMENT - MULTICHOICE*/
	public function processPayMultichoice(Request $request){

		$data = json_decode($request->getContent(), true);

		$getToken = Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->first();

		// return $getToken;

		if ($getToken) {
			if (Payvice::tokenExpiration($getToken->created_at) == true){
			//Payvice::timeAgo(strtotime($getToken->created_at)) >= 2
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token expired']);
			}

			if ($getToken->status == 1) {
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token already used']);
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
						$keyClr = hex2bin($encryptedPassword);
						$pin = hash('SHA256', $keyClr.$data['auth']);

						$mutiCdata = [
							"iuc" => $data["beneficiary"],
							"product_code" => $data["product_code"],
							"user_id" => $data["user_name"],
							"terminal_id" => $data["vice_id"],
							"pin" => $pin,
							"unit" => $data['service']
						];
						if (isset($data['amount']) && !empty($data['amount'])) {
							$mutiCdata['amount'] = $data['amount'];
						}




						$headers = [
							'Authorization' => env('IISYS_AUTH'),
							'sysid' => env('IISYS_BC'),
							'Content-Type' => 'application/json'
						];

						//dd($data);
						//\Log::debug("Request Log " . print_r($data, true));

						$pay = new \GuzzleHttp\Client();
						$res = $pay->post('http://197.253.19.75:8029/vas/multichoice/pay', ['json' => $mutiCdata, 'headers' => $headers]);
						if ($res->getStatusCode() == 200) {

							$multiResponse = json_decode($res->getBody()->getContents(), true);
							
							if ($multiResponse['error'] == false) {

								Vice::where('vice_id', $usrTID)->where('token', $data['token'])->update(['status' => 1]);
								$txnRef = uniqid();

								$txn = ['token' => $data['token'], 'vice' => $data['vice_id'], 'ref' => $txnRef, 'status' => 1, 'tran_ben' => $data['beneficiary'], 'tran_amount' => ""];
								Transaction::create($txn);
								return response()->json(
									[
										"message" => $data["service"]. " - Subscription was successful",
										"status" => 1,
										"date" => date('d/m/Y H:i:s', time()),
										"txn_ref" => $txnRef
									]
								);
							}else{
								$txnRef = uniqid();
								Vice::where('vice_id', $usrTID)->where('token', $data['token'])->update(['status' => 1]);
								$txn = ['token' => $data['token'], 'vice' => $data['vice_id'], 'ref' => $txnRef, 'status' => 0, 'tran_ben' => $data['beneficiary'], 'tran_amount' => ""];
								Transaction::create($txn);
								return response()->json(
									[
										"message" => $multiResponse['message'],
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
			return response()->json(
				[
					"message" => "Invalid token provided",
					"status" => 0,
					"date" => date('d/m/Y H:i:s', time()),
					"txn_ref" => ""
				]
			);
		}


	}


	public function subMultiChoice(Request $req){

		$validation = \Validator::make($req->all(), [
			'plan' => 'bail|required'

		], [

			'plan.required' => 'Plelase select a subscription plan'

		]);

		if ($validation->fails())
			return $validation->messages();


		$keyClr = hex2bin($purchase->session()->get('usrKeyPass'));
		$pin = hash('SHA256', $keyClr.$req->pin);

		$mutiCdata = [
			"iuc" => $req->session()->get('iuc'),
			"product_code" => $req->plan,
			"user_id" => $req->session()->get('curEm'),
			"terminal_id" => $req->session()->get('curAcc'),
			"pin" => $pin
		];

		$headers = [
			'Authorization' => env('IISYS_AUTH'),
			'sysid' => env('IISYS_BC'),
			'Content-Type' => 'application/json'
		];


		$pay = new \GuzzleHttp\Client();
		$res = $pay->post('http://197.253.19.75:8029/vas/multichoice/pay', ['json' => $mutiCdata, 'headers' => $headers]);
		if ($res->getStatusCode() == 200) {

			$multiResponse = json_decode($res->getBody()->getContents(), true);

			if ($multiResponse['error'] == true) {

				return response()->json([
					'status' => 0,
					'message' => $multiResponse['message']
				]);
			}else{

				$dataHist = [];
				if (History::create($dataHist)) {
					return response()->json([
						'status' => 1,
						'message' => "Cable TV subscription was successful"
					]);
				}


			}
		}else{
			return response()->json([
				'status' => 0,
				'message' => 'Unable to comminucate to VAS server. Please try again'
			]);
		}


	}


	public function proceedMultichoicePlan(Request $plan){
		\Session::put('usrPlan', $plan->plan);

		if (\Session::has('usrPlan')) {
			return response()->json(['status' => 1, 'message' => 'Enter you transaction pin']);
		}else{
			return response()->json(['status' => 0, 'message' => 'Unable to proceed. Please try again']);

		}
	}

	public function proceedSmilePlan(Request $plan){
		\Session::put('smilePlan', $plan->plan);

		if (\Session::has('smilePlan')) {
			return response()->json(['status' => 1, 'message' => 'Enter you transaction pin']);
		}else{
			return response()->json(['status' => 0, 'message' => 'Unable to proceed. Please try again']);

		}
	}


	public function proceedMultichoiceTranPin(Request $pin){
		\Session::put('tranPin', $pin->pin);

		if (\Session::has('tranPin')) {
			return response()->json(['status' => 1, 'message' => 'Select Payment Method']);
		}else{
			return response()->json(['status' => 0, 'message' => 'Unable to proceed. Please try again']);

		}
	}


	public function makePaymentMultichoice(Request $request){

		if (null == $request->session()->get('usrPlan') or null == $request->session()->get('tranPin')) {
			return response()->json([
				'status' => 0,
				'message' => 'Unable to proceed for payment'
			]);
		}else{


			$keyClr = hex2bin($request->session()->get('usrKeyPass'));
			$pin = hash('SHA256', $keyClr.$request->session()->get('tranPin'));

			$mutiCdata = [
				"iuc" => $request->session()->get('iuc'),
				"product_code" => $request->session()->get('usrPlan'),
				"user_id" => $request->session()->get('curEm'),
				"terminal_id" => $request->session()->get('curAcc'),
				"pin" => $pin,
				"unit" => $request->session()->get('unit')
			];

			$headers = [
				'Authorization' => env('IISYS_AUTH'),
				'sysid' => env('IISYS_BC'),
				'Content-Type' => 'application/json'
			];

			/*
			* TEST
			* http://197.253.19.75:8029/vas/multichoice/test/pay
			*/
			$pay = new \GuzzleHttp\Client();
			$res = $pay->post('http://197.253.19.75:8029/vas/multichoice/pay', ['json' => $mutiCdata, 'headers' => $headers]);
			if ($res->getStatusCode() == 200) {

				$multiResponse = json_decode($res->getBody()->getContents(), true);

				//dd($multiResponse);

				if ($multiResponse['error'] == true) {

					return response()->json([
						'status' => 0,
						'message' => $multiResponse['message']
					]);
				}else{

					return response()->json([
						'status' => 1,
						'message' => "Cable TV subscription was successful"
					]);

				}

			}


		}
	}



	public function makePaymentSmile(Request $request){

		if (null == $request->session()->get('smilePlan') or null == $request->session()->get('tranPin')) {
			return response()->json([
				'status' => 0,
				'message' => 'Unable to proceed for payment'
			]);
		}else{


			$keyClr = hex2bin($request->session()->get('usrKeyPass'));
			$pin = hash('SHA256', $keyClr.$request->session()->get('tranPin'));

			$SmileDataPost = [
				"account" => $request->session()->get('smlAcc'),
				"code" => $request->session()->get('usrPlan'),
				"price" => $request->price,
				"wallet" => $request->session()->get('curAcc'),
				"username" => $request->session()->get('curEm'),
				"pin" => $pin,
				"method" => "cash"
			];

			if ($request->session()->get('payMethod') === 'acc') {
				$buyUrl = 'http://197.253.19.75:8029/smile/buy-bundle';
			}else{
				$buyUrl = 'http://197.253.19.75:8029/smile/buy-bundle/phone';
			}

			$pay = new \GuzzleHttp\Client();
			$res = $pay->post($buyUrl, ['json' => $SmileDataPost]);
			if ($res->getStatusCode() == 200) {

				$smileResponse = json_decode($res->getBody()->getContents(), true);

				//dd($multiResponse);

				if ($smileResponse['status'] === 1) {

					return response()->json([
						'status' => 0,
						'message' => $smileResponse['message']
					]);
				}else{

					return response()->json([
						'status' => 1,
						'message' => "Smile bundle subscription was successful"
					]);

				}

			}


		}
	}



	public function validateEkoCustomer(Request $request){

		$data = json_decode($request->getContent(), true);

		/*INIT*/
		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$data['user_name'].'&control=INIT');
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);

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
					}else{

						/*VALIDATE CUSTOMER*/
						$validate = ["meter" => $data['meter']];
						$client = new \GuzzleHttp\Client();
						$res = $client->post('http://197.253.19.75:8029/ekedc/vas/validate', ['json' => $validate]);
						if ($res->getStatusCode() == 200) {
							$responseMsg = $res->getBody()->getContents();

							/*if ($data['vice_id'] == "44952823") {

								$evd = json_decode($responseMsg, true);
								if ($evd['status'] == 0) {
									unset($evd['status']);

									$evd['status'] = 1;


									return response()->json($evd);
								}else{

									unset($evd['status']);
									$evd['status'] = 0;
									return response()->json($evd);
								}



							}else{
								return $responseMsg;
							}*/

							return $responseMsg;

						}else{
							return response()->json(['status' => 0, 'message' => "Unable to validate customer", "error" => "HTTP ERROR: ".$res->getStatusCode()]);
						}

					}

				}
			}
		}
	}


	/*PROCESS EKO ELECTRICITY PAYMENT*/
	public function makeEkoPayment(Request $request){
		$data = json_decode($request->getContent(), true);

		if (Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->exists()) {

			$getToken = Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->first();

			if (Payvice::tokenExpiration($getToken->created_at) == true){
			//Payvice::timeAgo(strtotime($getToken->created_at)) >= 2
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token expired']);
			}

			if ($getToken->status == 1) {
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token already used']);
			}

			$client = new \GuzzleHttp\Client();
			$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$data['user_name'].'&control=INIT');
			if ($res->getStatusCode() == 200) {
				$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
				$fileContents = trim(str_replace('"', "'", $fileContents));
				$simpleXml = simplexml_load_string($fileContents);
				$json = json_encode($simpleXml);
				$phpArray = json_decode($json, true);

				if ($phpArray['tran']['result'] == 1) {
					return response()->json(
						[
							"message" => "Invalid Username provided",
							"status" => 0,
							"date" => date('d/m/Y H:i:s', time()),
							"txn_ref" => ""
						]
					);
				}else{

					$usrTID = $phpArray['tran']['macros_tid'];
					$getKey = explode('|', $phpArray['tran']['message']);
					$key = $getKey[1];

					$tidArray = str_split($data['vice_id']);
					$createClrKey = "";

					foreach ($tidArray as $tidChar) {
						if (!is_numeric($tidChar))
							$tidChar = 7;
						$createClrKey .= substr($key, $tidChar, 1);

					}

					$hex = hex2bin($createClrKey);
					$pass = $hex.$data['pwd'];


					$encryptedPassword = hash('SHA256', $pass);

					$tPin = $data['auth'];

					$keyClr = hex2bin($encryptedPassword);
					$encryptedPin = hash('SHA256', $keyClr.$tPin);

					/*PAYMENT DATA*/
					$payment = [
						"meter" => $data['meter'],
						"amount" => $data['amount'],
						"terminal_id" => $data['vice_id'],
						"phone" => $data['phone'],
						"user_id" => $data['user_name'],
						"type" => "cash",
						"password" => $data['pwd'],
						"pin" => $encryptedPin,
						"channel" => "WEB"
					];
					$responseToken = "";
					$bal = new \GuzzleHttp\Client();
					$res = $bal->post('http://197.253.19.75:8029/ekedc/vas/payment/process', ['json' => $payment]);
					if ($res->getStatusCode() == 200) {
						$response = json_decode($res->getBody()->getContents(), true);

						if (array_key_exists('token', $response)) {
							$responseToken = $response['token'];
						}else{
							$responseToken = null;
						}
						if ($response['status'] === 0) {

							Vice::where('vice_id', $usrTID)->where('token', $data['token'])->update(['status' => 1]);
							$txn = [
								'token' => $data['token'],
								'vice' => $data['vice_id'],
								'ref' => $response['ref'],
								'status' => 1,
								'tran_ben' => $data['meter'],
								'tran_amount' => $data['amount'],
								'tran_type' => 'EKEDC',
								'ie_token' => $responseToken,
								'payer_name' => $response['payer'],
								'payer_address' => $response['address']
							];
							Transaction::create($txn);

							$responseMsg = $response;
							/*if ($data['vice_id'] == "44952823") {

								unset($response['status']);

								$response['status'] = 1;


								return response()->json($response);

							}else{
								return response()->json($response);
							}*/

							return response()->json($response);

						}else if($response['status'] === 2){
							return response()->json(
								$response
							);
						}else{

							Vice::where('vice_id', $usrTID)->where('token', $data['token'])->update(['status' => 1]);
							$txn = [
								'token' => $data['token'] ?? "NIL",
								'vice' => $data['vice_id'] ?? "NIL",
								'ref' => $response['ref'] ?? "NIL",
								'status' => 0,
								'tran_ben' => $data['meter'] ?? "NIL",
								'tran_amount' => $data['amount'] ?? "NIL",
								'tran_type' => 'EKEDC',
								'ie_token' => $responseToken ?? "NIL",
								'payer_name' => $response['payer'] ?? "NIL",
								'payer_address' => $response['address'] ?? "NIL"
							];
							Transaction::create($txn);

							/*if ($data['vice_id'] == "44952823"){
								unset($response['status']);
								$response['status'] = 0;
								return response()->json(
									$response
								);

							}else{
								return response()->json(
									$response
								);
							}*/

							return response()->json(
								$response
							);

						}


					}else{

						return response()->json(
							[
								"message" => "An error occured. Please try again later",
								"status" => 0,
								"date" => date('d/m/Y H:i:s', time()),
								"txn_ref" => ""
							]
						);
					}

				}

			}



		}else{
			/*TOKEN NOT FOUND*/
			return response()->json(
				[
					"message" => "Unkown request token",
					"status" => 0,
					"date" => date('d/m/Y H:i:s', time()),
					"txn_ref" => null
				]
			);
		}




	}


	/*VALIDATE ENUGU*/

	public function validateEnuguCustomer(Request $request){

		$data = json_decode($request->getContent(), true);

		/*INIT*/
		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$data['user_name'].'&control=INIT');
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);

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
					}else{

						/*VALIDATE CUSTOMER*/
						$validate = [
							"wallet" => $data['vice_id'],
							"username" => $data['user_name'],
							"type" => $data['type'],
							"channel" => "WEB",
							"account" => $data['meter']
						];

						$client = new \GuzzleHttp\Client();
						$res = $client->post('http://197.253.19.75:8029/vas/eedc/validation', ['json' => $validate]);
						if ($res->getStatusCode() == 200) {
							$responseMsg = $res->getBody()->getContents();

							return $responseMsg;


						}else{
							return response()->json(['status' => 0, 'message' => "Unable to validate customer", "error" => "HTTP ERROR: ".$res->getStatusCode()]);
						}

					}

				}
			}
		}
	}


	/*MAKE ENUGU PAYMENT*/
	public function enuguElectPayment(Request $request){
		$data = json_decode($request->getContent(), true);

		if (Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->exists()) {

			$getToken = Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->first();

			if (Payvice::tokenExpiration($getToken->created_at) == true){
			//Payvice::timeAgo(strtotime($getToken->created_at)) >= 2
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token expired']);
			}

			if ($getToken->status == 1) {
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token already used']);
			}

			$client = new \GuzzleHttp\Client();
			$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$data['user_name'].'&control=INIT');
			if ($res->getStatusCode() == 200) {
				$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
				$fileContents = trim(str_replace('"', "'", $fileContents));
				$simpleXml = simplexml_load_string($fileContents);
				$json = json_encode($simpleXml);
				$phpArray = json_decode($json, true);

				if ($phpArray['tran']['result'] == 1) {
					return response()->json(
						[
							"message" => "Invalid Username provided",
							"status" => 0,
							"date" => date('d/m/Y H:i:s', time()),
							"txn_ref" => ""
						]
					);
				}else{

					$usrTID = $phpArray['tran']['macros_tid'];
					$getKey = explode('|', $phpArray['tran']['message']);
					$key = $getKey[1];

					$tidArray = str_split($data['vice_id']);
					$createClrKey = "";

					foreach ($tidArray as $tidChar) {
						if (!is_numeric($tidChar))
							$tidChar = 7;
						$createClrKey .= substr($key, $tidChar, 1);

					}

					$hex = hex2bin($createClrKey);
					$pass = $hex.$data['pwd'];


					$encryptedPassword = hash('SHA256', $pass);

					$tPin = $data['auth'];

					$keyClr = hex2bin($encryptedPassword);
					$encryptedPin = hash('SHA256', $keyClr.$tPin);

					/*PAYMENT DATA*/
					$payment = [
						"wallet" => $data['vice_id'],
						"username" => $data['user_name'],
						"password" => $data['pwd'],
						"pin" => $encryptedPin,
						"type" => $data['type'],
						"channel" => "WEB",
						"account" => $data['meter'],
						"amount" => $data['amount'],
						"phone" => $data['meter'],
						"productCode" => $data['code'],
						"name" =>  $data['name'],
						"paymentMethod" => "cash",
						"clientReference" => uniqid()

					];

					$responseToken = "";
					$bal = new \GuzzleHttp\Client();
					$res = $bal->post('http://197.253.19.75:8029/vas/eedc/payment', ['json' => $payment]);
					if ($res->getStatusCode() == 200) {
						$response = json_decode($res->getBody()->getContents(), true);

						if (array_key_exists('token', $response)) {
							$responseToken = $response['token'];
						}else{
							$responseToken = null;
						}
						if ($response['status'] === 1) {

							Vice::where('vice_id', $usrTID)->where('token', $data['token'])->update(['status' => 1]);
							$txn = [
								'token' => $data['token'],
								'vice' => $data['vice_id'],
								'ref' => $response['reference'],
								'status' => 1,
								'tran_ben' => $data['meter'],
								'tran_amount' => $data['amount'],
								'tran_type' => 'ENUGU',
								'ie_token' => $responseToken,
								'payer_name' => $response['name'],
								'payer_address' => "NIL"
							];
							Transaction::create($txn);

							return response()->json($response);

						}else if($response['status'] === 2){
							return response()->json(
								$response
							);
						}else{

							Vice::where('vice_id', $usrTID)->where('token', $data['token'])->update(['status' => 0]);
							$txn = [
								'token' => $data['token'] ?? "NIL",
								'vice' => $data['vice_id'] ?? "NIL",
								'ref' => $response['reference'] ?? "NIL",
								'status' => 0,
								'tran_ben' => $data['meter'] ?? "NIL",
								'tran_amount' => $data['amount'] ?? "NIL",
								'tran_type' => 'ENUGU',
								'ie_token' => $responseToken ?? "NIL",
								'payer_name' => $response['name'] ?? "NIL",
								'payer_address' => "NIL"
							];
							Transaction::create($txn);

							return response()->json(
								$response
							);

						}


					}else{

						return response()->json(
							[
								"message" => "An error occured. Please try again later",
								"status" => 0,
								"date" => date('d/m/Y H:i:s', time()),
								"txn_ref" => ""
							]
						);
					}

				}

			}



		}else{
			/*TOKEN NOT FOUND*/
			return response()->json(
				[
					"message" => "Unkown request token",
					"status" => 0,
					"date" => date('d/m/Y H:i:s', time()),
					"txn_ref" => null
				]
			);
		}


	}

}