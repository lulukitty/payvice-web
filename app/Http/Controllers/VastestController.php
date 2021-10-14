<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vice;
use Payvice;
use App\Transaction;


class VastestController extends Controller
{

	public function getMultiChoiceLookup(Request $request){

		$data = json_decode($request->getContent(), true);
		dd($data);
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
				'Authorization' => 'IISYSGROUP c1e750cf89b05b0fc56eecf6fc25cce85e2bb8e0c46d7bfed463f6c6c89d4b8e',
				'sysid' => 'ee2dadd1e684032929a2cea40d1b9a2453435da4f588c1ee88b1e76abb566c31',
				'Content-Type' => 'application/json'
				];
				$chk = new \GuzzleHttp\Client();
				$res = $chk->post('http://197.253.19.75:8090/vas/multichoice/test/lookup', ['json' => $reqContent, 'headers' => $headers]);
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
				'Authorization' => 'IISYSGROUP c1e750cf89b05b0fc56eecf6fc25cce85e2bb8e0c46d7bfed463f6c6c89d4b8e',
				'sysid' => 'ee2dadd1e684032929a2cea40d1b9a2453435da4f588c1ee88b1e76abb566c31',
				'Content-Type' => 'application/json'
				];
				$chk = new \GuzzleHttp\Client();
				$res = $chk->post('http://197.253.19.75:8090/vas/multichoice/test/validate', ['json' => $reqContent, 'headers' => $headers]);
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

		if (count($getToken) > 0) {
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
						"password" => $data["pwd"]
						//"pin" => $pin
						];

						$headers = [
						'Authorization' => 'IISYSGROUP c1e750cf89b05b0fc56eecf6fc25cce85e2bb8e0c46d7bfed463f6c6c89d4b8e',
						'sysid' => 'ee2dadd1e684032929a2cea40d1b9a2453435da4f588c1ee88b1e76abb566c31',
						'Content-Type' => 'application/json'
						];


						$pay = new \GuzzleHttp\Client();
						$res = $pay->post('http://197.253.19.75:8090/vas/multichoice/test/pay', ['json' => $mutiCdata, 'headers' => $headers]);
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


}