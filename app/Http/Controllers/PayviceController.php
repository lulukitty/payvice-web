<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vice;
use Payvice;
use App\Transaction;


class PayviceController extends Controller
{
	public function register(Request $req){
		$termid = '203301ZA';
		$email = 'ewo@live.com';
		$username = 'michelkal';

		$hash = hash('sha512', utf8_encode($termid.$email.$username), false);

		$regUser = "?action=TAMS_REG&termid=".$termid."&userid=".$email."&username=".$username."&email=".$email."&device_id=0123456789&key=".$hash;
		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php'.$regUser);

		if ($res->getStatusCode() == 200) {

			//$result = json_decode($res->getBody()->getContents(), true);

			//print_r($res->getBody()->getContents());

			$fileContents = str_replace(array("", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));

			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);

			$phpArray = json_decode($json, true);

			$clrKey = "";

			$splitTID = str_split($phpArray['tran']['macros_tid']);
			$key = explode('|', $phpArray['tran']['key']);

			foreach ($splitTID as $tidChar) {
				if (!is_numeric($tidChar))
					$tidChar = 7;

				$clrKey .= substr($key[1], $tidChar, 1);

			}

			return redirect('/vice/complete?clr='.$clrKey.'&userTID='.$phpArray['tran']['macros_tid'].'&userEmail='.$email);


		}

	}



	public function completion(Request $comp){

		$clrKey = $comp->get('clr');
		$email = $comp->get('userEmail');
		$userTerm = $comp->get('userTID');

		/*echo $clrKey;
		exit();*/

		$myPassword = "Michel10";
		$myPin = 1020;

		$passHash = hash_hmac('SHA512', $myPassword, $clrKey);

		$hashPin = hash_hmac('SHA512', $myPin, $passHash);

			/*echo $passHash;

			exit();*/

			$completion = "action=TAMS_PIN_UPDATE&termid=".$userTerm;
			$completion .= "&userid=".$email."&password=1234&newpassword=".$passHash;
			$completion .= "&vercode=28ff&pin=1234&newpin=".$hashPin;
			$client = new \GuzzleHttp\Client();
			$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?'.$completion, ['header' => 'application/xml']);

			if ($res->getStatusCode() == 200) {
				$fileContents = str_replace(array("", "\r", "\t"), '', $res->getBody()->getContents());
				$fileContents = trim(str_replace('"', "'", $fileContents));

				$simpleXml = simplexml_load_string($fileContents);
				$json = json_encode($simpleXml);

				$phpArray = json_decode($json, true);

				print_r($phpArray);

				exit();
			}
		}



		public function base64url_encode($data) {
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
		}



		public function encode($data, $use_padding = false){
			$encoded = strtr(base64_encode($data), '+/', '-_');
			return true === $use_padding ? $encoded : rtrim($encoded, '=');
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

	public function processApiCallVisionTek(Request $request){

		/*return response()->json(['status' => 0, 'message' => 'API service blocked']);
		exit();*/

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


		/*if ($data['service'] != "MTNVTU"){
			return response()->json(['status' => 0, 'message' => 'Unauthorized Service. Token allowed for MTN only']);

		}*/

		/*CHECK BALANCE*/
		$wallBal = "";
		$bal = new \GuzzleHttp\Client();
		$res = $bal->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=BALANCE&termid='.$data['vice_id'].'&userid='.$data['user_name']);
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);


			$wallBal = explode('N', $phpArray['tran']['balance']);


		}

		$usrWltBal = str_replace(',', '', trim($wallBal[1]));

		/*return $usrWltBal."<<>>". $data['amount'];
		exit();*/

		if ($usrWltBal < $data['amount']) {
			return response()->json(['status' => 0, 'message' => 'Low wallet fund. Please fund your wallet']);
		}

		/*START*/
		switch ($data['service']) {
			case 'MTNVTU':
			case 'AIRTELVTU':
			case 'GLOVTU':
			case 'ETISALATVTU':


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

						$userCredentials = [
							'email' => $userData[5],
							'name' =>  $userData[0],
							'account' => $userData[2]
						];

						$name = explode('<macros>', $userData[0]);

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

								$txn = ['token' => $data['token'], 'vice' => $data['vice_id'], 'ref' => $txnRef, 'status' => 1, 'tran_ben' => $data['phone'], 'tran_amount' => $data['amount'], 'tran_type' => 'airtime'];
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
								$txn = ['token' => $data['token'], 'vice' => $data['vice_id'], 'ref' => $txnRef, 'status' => 0, 'tran_ben' => $data['phone'], 'tran_amount' => $data['amount'], 'tran_type' => 'airtime'];
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

			break;

			case 'IE':
			/*case 'IE_TOKEN':
			case 'IE_POST':*/

			$lookupAcc = "";
			$lookup = "";
			$func = "";
			$val = "";

			if (!empty($data['cus_meter'])) {
				$lookupAcc = $data['cus_meter'];
				$lookup = "vend";
				$func = "getcus";
				$val = "met";
			}else{
				$lookupAcc = $data['cus_account'];
				$lookup = "postpaid";
				$func = $data['type'];
				$val = "acct";

			}

			$lookupStr = "func=".$func."&lookup=".$lookup."&termID=".$data['vice_id']."&vice_id=".$data['user_name']."&vice_pwd=".str_replace('#', '%23', $data['pwd'])."&vice_tid=".$data['vice_id']."&".$val."=".$lookupAcc;
			/*Make the call*/
			$client = new \GuzzleHttp\Client();
			$res = $client->post('http://197.253.19.75/tams/eftpos/op/conlog.php?'.$lookupStr);
			if ($res->getStatusCode() == 200) {
				$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
				$fileContents = trim(str_replace('"', "'", $fileContents));
				$simpleXml = simplexml_load_string($fileContents);
				$json = json_encode($simpleXml);
				$phpArray = json_decode($json, true);


				/*print_r($phpArray);
				exit();*/

				if ($phpArray['tran']['result'] == "2") {
					return response()->json(
						[
							"message" => "Lookup failed. Customer information not found",
							"status" => 0,
							"date" => date('d/m/Y H:i:s', time())
						]
					);
				}else{


					/*Return customer Details*/
					$custDetails = explode('|', $phpArray['tran']['message']);

					return response()->json(
						[
							"message" => "Customer name validation was successful",
							"status" => 1,
							"date" => date('d/m/Y H:i:s', time()),
							"cust_name" => $custDetails[0],
							"cust_address" => $custDetails[1]
						]
					);

				}

			}
			break;

			default:
			return response()->json(['status' => 0, 'message' => 'Service Unavailable']);
			break;
		}
		/*END*/
	}else{
		return response()->json(['status' => 0, 'message' => 'Failed. Please check your token/Vice ID']);
	}

}


/*Proceed with IE Token when Name validation is successful*/
public function purchaseIkejaElectricity(Request $ie){

	$data = json_decode($ie->getContent(), true);
	$getToken = Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->first();

	if (Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->exists()) {
		if (Payvice::tokenExpiration($getToken->created_at) == true){
			//Payvice::timeAgo(strtotime($getToken->created_at)) >= 2
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token expired']);
		}

		if ($getToken->status == 1) {
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token already used']);
		}


		/*CHECK BALANCE*/
		$wallBal = "";
		$bal = new \GuzzleHttp\Client();
		$res = $bal->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=BALANCE&termid='.$data['vice_id'].'&userid='.$data['user_name']);
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);


			$wallBal = explode('N', $phpArray['tran']['balance']);

		}

		$usrWltBal = str_replace(',', '', trim($wallBal[1]));


		if ($usrWltBal < floatval($data['amount'])) {
			return response()->json(['status' => 0, 'message' => 'Low wallet fund. Please fund your wallet']);
		}

		$str = "";
		switch ($data['service_type']) {
			case 'vend':
			$type = "sts";
			$func = 'vend';

			$requestString = "paymentMethod=cash&func=".$func."&met=".$data['cus_meter'];
			$requestString .= "&amount=".$data['amount']."&termID=".$data['vice_id'];
			$requestString .= "&type".$type."=&vice_pwd=".str_replace('#', '%23', $data['pwd'])."&vice_tid=".$data['vice_id'];
			$requestString .= "&vice_id=".$data['user_name'];

			$str = $requestString;
			break;

			case 'pay':
			$type = "Postpaid";
			$func = 'pay';

			$requestString = "paymentMethod=cash&func=".$func."&acct=".$data['cus_account'];
			$requestString .= "&amount=".$data['amount']."&termID=".$data['vice_id'];
			$requestString .= "&type".$type."=&vice_pwd=".str_replace('#', '%23', $data['pwd'])."&vice_tid=".$data['vice_id'];
			$requestString .= "&vice_id=".$data['user_name'];

			$str = $requestString;
			break;
		}

		$client = new \GuzzleHttp\Client();
		$res = $client->get('http://197.253.19.75/tams/eftpos/op/conlog.php?'.$str);

		if ($res->getStatusCode() == 200) {

			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);

			$txnRef = uniqid();

			if ($phpArray['tran']['result'] == "1" && $phpArray['tran']['status'] == "00") {
				Vice::where('vice_id', $data['vice_id'])->where('token', $data['token'])->update(['status' => 1]);
				//$txn = ['token' => $data['token'], 'vice' => $data['vice_id'], 'ref' => $txnRef, 'status' => 1, 'tran_ben' => $data['phone'], 'tran_amount' => $data['amount']];

				$tran = new Transaction;
				$tran->token = $data['token'];
				$tran->vice = $data['vice_id'];
				$tran->ref = $txnRef;
				$tran->status = 1;
				$tran->tran_ben = $data['phone'];
				$tran->tran_amount = $data['amount'];
				$tran->tran_type = 'ie';

				if($tran->save()){

					if ($data['service_type'] == 'vend') {
						$responseToken = explode('|', $phpArray['tran']['message']);
						$tokenVal = explode("*", $responseToken[21]);

						Transaction::where('id', $tran->id)->update([
							'ie_token' => str_replace("~", "", $tokenVal[1]),
							'payer_name' => str_replace("Conlog", "", $responseToken[7]),
							'payer_address' => $responseToken[8]
						]);

						return response()->json(
							[
								"message" => "Credit purchase was successful",
								"status" => 1,
								"date" => date('d/m/Y H:i:s', time()),
								"txn_ref" => $txnRef,
								"token_value" => str_replace("~", "", $tokenVal[1]),
								"address" => $responseToken[8],
								"payer" => str_replace("Conlog", "", $responseToken[7]),
								"txn_ref" => $txnRef
							]
						);
					}else{
						$responseToken = explode('|', $phpArray['tran']['message']);

						Transaction::where('id', $tran->id)->update([
							'payer_name' => $responseToken[12],
							'payer_address' => str_replace("Address", "", $responseToken[13])
						]);

						return response()->json(
							[
								"message" => "Completed successfully",
								"status" => 1,
								"date" => date('d/m/Y H:i:s', time()),
								"txn_ref" => $txnRef,
								"address" => str_replace("Address", "", $responseToken[13]),
								"payer" => $responseToken[12]
							]
						);
					}

				}


			}else{

				$txnRef = uniqid();
				Vice::where('vice_id', $data['vice_id'])->where('token', $data['token'])->update(['status' => 1]);
				$txn = ['token' => $data['token'], 'vice' => $data['vice_id'], 'ref' => $txnRef, 'status' => 0, 'tran_ben' => $data['phone'], 'tran_amount' => $data['amount']];
				Transaction::create($txn);

				$msg = explode("|", $phpArray['tran']['message']);

				return response()->json(
					[
						"message" => substr($msg[2], 0, 50).'...',
						"status" => 0,
						"date" => date('d/m/Y H:i:s', time()),
						"txn_ref" => $txnRef
					]
				);


			}



		}

	}else{
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


/*WALLET TO WALLET TRANSFER*/
public function walletTowalletTran(Request $request){
	$data = json_decode($request->getContent(), true);

	$getToken = Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->first();

	if ($getToken) {
		if (Payvice::tokenExpiration($getToken->created_at) == true){
			//Payvice::timeAgo(strtotime($getToken->created_at)) >= 2
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token expired']);
		}

		if ($getToken->status == 1) {
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token already used']);
		}

		if (floatval($data['amount']) < 50) {
			return response()->json(['status' => 0, 'message' => 'Transaction amount is lower than the minimum value of N50']);

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

				$amt = $data['amount'];
				$toWallet = $data['beneficiary'];
				$tPin = $data['auth'];

				$keyClr = hex2bin($encryptedPassword);
				$encryptedPin = hash('SHA256', $keyClr.$tPin);

				$request = "action=TAMS_WEBAPI&amount=".$amt."&control=Transfer&pin=".$encryptedPin;
				$request .= "&recipient_terminal_id=".$toWallet."&termid=".$data['vice_id'];
				$request .= "&userid=".$data['user_name'];

				$bal = new \GuzzleHttp\Client();
				$res = $bal->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?'.$request);
				if ($res->getStatusCode() == 200) {
					$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
					$fileContents = trim(str_replace('"', "'", $fileContents));
					$simpleXml = simplexml_load_string($fileContents);
					$json = json_encode($simpleXml);
					$phpArray = json_decode($json, true);


					if (!empty($phpArray)) {
						if ($phpArray['tran']['result'] == 1) {
							return response()->json(['status' => 1, 'msg' => $phpArray['tran']['message']]);
						}else{

							$txnRef = uniqid();
							Vice::where('vice_id', $usrTID)->where('token', $data['token'])->update(['status' => 1]);
							$txn = ['token' => $data['token'], 'vice' => $data['vice_id'], 'ref' => $txnRef, 'status' => 1, 'tran_ben' => $data['beneficiary'], 'tran_amount' => $data['amount'], 'tran_type' => 'transfer'];
							Transaction::create($txn);
							return response()->json(
								[
									"message" => "Fund transfered successfully",
									"status" => 1,
									"date" => date('d/m/Y H:i:s', time()),
									"txn_ref" => $txnRef
								]
							);

						}
					}else{

						$txnRef = uniqid();
						Vice::where('vice_id', $usrTID)->where('token', $data['token'])->update(['status' => 1]);
						$txn = ['token' => $data['token'], 'vice' => $data['vice_id'], 'ref' => $txnRef, 'status' => 0, 'tran_ben' => $data['beneficiary'], 'tran_amount' => $data['amount'], 'tran_type' => 'transfer'];
						Transaction::create($txn);
						return response()->json(
							[
								"message" => "Unknown Recipient wallet",
								"status" => 0,
								"date" => date('d/m/Y H:i:s', time()),
								"txn_ref" => $txnRef
							]
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
