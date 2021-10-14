<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vice;
use Payvice;
use App\Transaction;

class BankingController extends Controller
{
	public function lookupAccount(Request $request){


		$data = json_decode($request->getContent(), true);


		if (count($data) < 5) {
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call']);
		}

		
		if (Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->exists()) {

			$getToken = Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->first();

			if (Payvice::tokenExpiration($getToken->created_at) == true){
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token expired']);
			}

			if ($getToken->status == 1) {
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token already used']);
			}

			$bal = new \GuzzleHttp\Client();
			$lookupData = [
			"action"=> "lookup",
			"beneficiary" => $data['account_num'],
			"vendorBankCode" => Payvice::banksSortCode($data['bank_name']),
			"walletID" => $data['vice_id'],
			"username" => $data['user_name'],
			"password" => $data['pwd']
			];
			$res = $bal->post('http://basehuge.itexapp.com/tams/tams/transfer-engine.php', ['json' => $lookupData]);
			if ($res->getStatusCode() == 200) {
				
				return $res->getBody()->getContents();

			}else{
				return response()->json([
					'status' => 1,
					'message' => 'The server was unable to handle request',
					'error_code' => 'HTTP error code '.$res->getStatusCode()
					]);
			}

		}else{
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Unkown transaction Token']);
		}

	}



	public function toAccountTransfer(Request $request){
		$data = json_decode($request->getContent(), true);


		if (count($data) < 5) {
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call']);
		}

		$getToken = Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->first();

		if (count($getToken->token) > 0) {
			if (Payvice::tokenExpiration($getToken->created_at) == true){
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token expired']);
			}

			if ($getToken->status == 1) {
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token already used']);
			}

			$bal = new \GuzzleHttp\Client();
			$lookupData = [
			"action"=> "transfer",
			"method" => "cash",
			"beneficiary" => $data['account_num'],
			"amount" => $data['amount'],
			"vendorBankCode" => Payvice::banksSortCode($data['bank_name']),
			"walletID" => $data['vice_id'],
			"username" => $data['user_name'],
			"password" => $data['pwd']
			];
			$nonce = hash("SHA512", $data['vice_id'].time());
			$sign = $nonce.env('BANKING_TOKEN').base64url_encode(json_encode($lookupData));
			$header = [
			'ITEX-Signature' => hash("SHA512", $sign),
			'ITEX-Nonce' => $nonce
			];

			//dd($sign);

			$res = $bal->post('http://basehuge.itexapp.com/tams/tams/transfer-engine.php', ['json' => $lookupData, 'header' => $header]);
			if ($res->getStatusCode() == 200) {
				
				return $res->getBody()->getContents();

			}else{
				return response()->json([
					'status' => 1,
					'message' => 'The server was unable to handle request',
					'error_code' => 'HTTP error code '.$res->getStatusCode()
					]);
			}

		}else{
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Unkown transaction Token']);
		}
	}


	function base64url_encode($data) { 
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	} 


	public function cashWithdrawal(Request $request){
		$data = json_decode($request->getContent(), true);


		if (count($data) < 5) {
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call']);
		}

		$getToken = Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->first();

		if (count($getToken->token) > 0) {
			if (Payvice::tokenExpiration($getToken->created_at) == true){
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token expired']);
			}

			if ($getToken->status == 1) {
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token already used']);
			}

			$bal = new \GuzzleHttp\Client();
			$lookupData = [
			"action"=> "withdrawal",
			"method" => "cash",
			"beneficiary" => $data['account_num'],
			"amount" => $data['amount'],
			"vendorBankCode" => Payvice::banksSortCode($data['bank_name']),
			"walletID" => $data['vice_id'],
			"username" => $data['user_name'],
			"password" => $data['pwd']
			];

			$nonce = hash("SHA512", $data['vice_id'].time());
			$sign = $nonce.env('BANKING_TOKEN').base64_encode(urlencode(json_encode($lookupData)));
			$header = [
			'ITEX-Signature' => $sign,
			'ITEX-Nonce' => $nonce
			];

			$res = $bal->post('http://basehuge.itexapp.com/tams/tams/transfer-engine.php', ['json' => $lookupData, 'header' => $header]);
			if ($res->getStatusCode() == 200) {
				
				return $res->getBody()->getContents();

			}else{
				return response()->json([
					'status' => 1,
					'message' => 'The server was unable to handle request',
					'error_code' => 'HTTP error code '.$res->getStatusCode()
					]);
			}

		}else{
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Unkown transaction Token']);
		}
	}


	public function cashDeposit(Request $request){
		$data = json_decode($request->getContent(), true);


		if (count($data) < 5) {
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call']);
		}

		$getToken = Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->first();

		if (count($getToken->token) > 0) {
			if (Payvice::tokenExpiration($getToken->created_at) == true){
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token expired']);
			}

			if ($getToken->status == 1) {
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token already used']);
			}

			$bal = new \GuzzleHttp\Client();
			$lookupData = [
			"action"=> "deposit",
			"method" => "cash",
			"beneficiary" => $data['account_num'],
			"amount" => $data['amount'],
			"vendorBankCode" => Payvice::banksSortCode($data['bank_name']),
			"walletID" => $data['vice_id'],
			"username" => $data['user_name'],
			"password" => $data['pwd']
			];

			$nonce = hash("SHA512", $data['vice_id'].time());
			$sign = $nonce.env('BANKING_TOKEN').base64_encode(urlencode(json_encode($lookupData)));
			$header = [
			'ITEX-Signature' => $sign,
			'ITEX-Nonce' => $nonce
			];

			$res = $bal->post('http://basehuge.itexapp.com/tams/tams/transfer-engine.php', ['json' => $lookupData, 'header' => $header]);
			if ($res->getStatusCode() == 200) {
				
				return $res->getBody()->getContents();

			}else{
				return response()->json([
					'status' => 1,
					'message' => 'The server was unable to handle request',
					'error_code' => 'HTTP error code '.$res->getStatusCode()
					]);
			}

		}else{
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Unkown transaction Token']);
		}
	}


	/*MIGS CARD TRANSACTION*/
	public function migsCardtransactions(Request $request){

		$data = json_decode($request->getContent(), true);


		if (count($data) < 5) {
			return response()->json(['status' => 0, 'message' => 'Unauthorized API call']);
		}

		$getToken = Vice::where('token', $data['token'])->where('vice_id', $data['vice_id'])->first();

		if (count($getToken->token) > 0) {
			if (Payvice::tokenExpiration($getToken->created_at) == true){
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token expired']);
			}

			if ($getToken->status == 1) {
				return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Token already used']);
			}

			$bal = new \GuzzleHttp\Client();
			/*
			* currencyCode
			* amount
			* CVV
			* expiryDate
			* pan
			* token
			* vice_id
			* user_name
			* pwd
			* 
			*/
			$client = new \GuzzleHttp\Client();
			$res = $client->post('http://basehuge.itexapp.com/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$data['user_name'].'&control=INIT');
			if ($res->getStatusCode() == 200) {
				$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
				$fileContents = trim(str_replace('"', "'", $fileContents));
				$simpleXml = simplexml_load_string($fileContents);
				$json = json_encode($simpleXml);
				$phpArray = json_decode($json, true);

				if ($phpArray['tran']['result'] == 1) {

					return response()->json([
						'status' => 0, 
						'message' => 'Unkown user details provided',
						'date' => date("d/m/Y H:i:s"),
						'ref' => NULL
						]);

				}else{

					/*DO LOGIN*/

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

					$login = new \GuzzleHttp\Client();
					$res = $login->post('http://basehuge.itexapp.com/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid='.$usrTID.'&userid='.$usr->email.'&password='.$encryptedPassword);
					if ($res->getStatusCode() == 200) {
						$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
						$fileContents = trim(str_replace('"', "'", $fileContents));
						$simpleXml = simplexml_load_string($fileContents);
						$json = json_encode($simpleXml);
						$phpArray = json_decode($json, true);

						if ($phpArray['tran']['result'] == 1)
							return response()->json([
								'status' => 0, 
								'message' => $phpArray['tran']['message'],
								'date' => date("d/m/Y H:i:s"),
								'ref' => NULL
								]);

						/*LOGIN SUCCEEDED*/
						$Title = "PHP VPC 3-Party";
						


						/*if ($res->getStatusCode() == 200) {

							return $res->getBody()->getContents();

						}else{
							return response()->json([
								'status' => 1,
								'message' => 'The server was unable to handle request',
								'error_code' => 'HTTP error code '.$res->getStatusCode()
								]);
}*/

}

/*END LOGIN*/

}


}else{
	return response()->json(['status' => 0, 'message' => 'Unauthorized API call. Unkown transaction Token']);
}

}


}

}
