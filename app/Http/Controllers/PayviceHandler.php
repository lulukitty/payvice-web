<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayviceHandler extends Controller
{
	public function getHomePage(){
		return view('home');
	}


	/*STEP ONE*/
	public function postStepOne(Request $req){

		$termid = '203301ZA';
		$email = $req->email;
		$username = $req->name;
		

		$hash = hash('sha512', utf8_encode($termid.$email.$username), false);

		$regUser = "?action=TAMS_REG&termid=".$termid."&userid=".$email."&username=".$username."&email=".$email."&device_id=0123456789&key=".$hash;
		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php'.$regUser);

		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));

			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);

			$phpArray = json_decode($json, true);

			if ($phpArray['tran']['result'] == 1){
				return $phpArray['tran']['message'];
			}else{

				$clrKey = "";

				$splitTID = str_split($phpArray['tran']['macros_tid']);
				$key = explode('|', $phpArray['tran']['key']);
				foreach ($splitTID as $tidChar) {
					if (!is_numeric($tidChar))
						$tidChar = 7;

					$clrKey .= substr($key[1], $tidChar, 1);

				}

				$req->session()->put('clr', $clrKey);
				$req->session()->put('userTID', $phpArray['tran']['macros_tid']);
				$req->session()->put('userEmail', $email);

				return "success";

				
			}

		}
	}//END - STEP ONE



	/*STEP TWO*/
	public function postRegPhaseTwo(Request $pass){

		$validator = \Validator::make($pass->all(), [
			'password' => 'bail|required|min:8'

		], 
		[
			'password.required' => 'Please choose a password',
			'password.min' => 'Password must be at least 8 characters',
		]);

		if ($validator->fails())
			return $validator->message();
		
		if( !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $pass->password)){
			return 'Password Must contain at least one lowercase, one uppercase and one number';
		};

		$pass->session()->put('passStepTwo', $pass->password);

		return "success";
	}//END - STEP TWO



	/*STEP THREE*/
	public function completeStepThree(Request $three){
		$validator = \Validator::make($three->all(), [
			'tranpin' => 'bail|required|min:4|max:4'
		], 
		[
			'tranpin.required' => 'Please choose a transaction pin',
			'tranpin.min' => 'Transaction must be 4 digit',
			'tranpin.max' => 'Transaction must be 4 digit'
		]);


		if ($validator->fails()) 
			return $validator->message();

		$three->session()->put('userTran', $three->tranpin);

		return 'success';

	}//END - STEP THREE


	/*COMPLETING USER REGISTRATION*/
	public function postCompletionUser(Request $request){

		$clrKey = hex2bin($request->session()->get('clr'));
		$termId = $request->session()->get('userTID');
		$userEmail = $request->session()->get('userEmail');
		$userPin = $request->session()->get('userTran');
		$userPassword = $request->session()->get('passStepTwo');

		$referralCode = "";

		if (null != $request->session()->get('referral')) {
			$referralCode = $request->session()->get('referral');
		}else{
			$referralCode = "";
		}

		$passHash = hash('SHA256', $clrKey.$userPassword);
		$hexPass = hex2bin($passHash);
		$hashPin = hash('SHA256', $hexPass.$userPin);

		$completion = "action=TAMS_PIN_UPDATE&termid=".$termId;
		$completion .= "&userid=".$userEmail."&password=1234&newpassword=".$passHash;
		$completion .= "&vercode=".$request->verificCode."&pin=1234&newpin=".$hashPin;
		$completion .= "&referalcode=".$referralCode;
		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?'.$completion);

		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));

			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);

			$phpArray = json_decode($json, true);

			if ($phpArray['tran']['result'] == 0) {
				return "success";

			}else{
				return "Could not complete registration. Please try again";
			}
		}


	}//END - COMPLETION




	/*PASSWORD RECOVERY*/
	public function getUserNewPassword(Request $req){

		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/recovery.php?action=RESET&usrName='.$req->email.'&usrEmail='.$req->email);

		if ($res->getStatusCode() == 200) {

			if ($res->getBody()->getContents() != "Invalid User ID or Email" || $res->getBody()->getContents() != "Request does not contain valid parameters") {
				return "success";
				//return $res->getBody()->getContents();
			}else{
				return $res->getBody()->getContents();
			}
			
		}
	}



	/*CREATE NEW PASSWORD*/
	public function PostUserNewPassword(Request $usr){
		
		if (null == $usr->session()->get('usrEml') || null == $usr->session()->get('userTid'))
			return "Error - Recovery link might have been long overdue";

		$control = 'PASSRESET';
		$password = env('PAYVICE_RECOVERY');
		$action = 'TAMS_PIN_UPDATE';
		$Update = 'changePW';

		$userid = $usr->session()->get('usrEml');
		$termid = $usr->session()->get('userTid');


		$today = date("Y-m-d");
		$securityTag= env('TAMS_SECURITY_KEY').$today.$userid.$termid;
		$hashedRequestBody = base64_encode(bin2hex(hash('sha512', utf8_encode($securityTag), true)));


		$client = new \GuzzleHttp\Client();
		$res = $client->post("http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_PIN_UPDATE&password=".$usr->password2."&newpassword=".$usr->password2."&termid=".$termid."&userid=".$userid."&control=PASSRESET&userkey=".$hashedRequestBody."&OTP=".$usr->otp);

		if ($res->getStatusCode() == 200) {
			if ($res->getBody()->getContents() == "Unknown error") {
				return "Unknow Userid/Password";
			}else{
				
				try
				  {
					\Log::info("TAMS RESPONSE AFTER PASSWORD CHANGE 4 ".$res->getBody());
  
					$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody());
					$fileContents = trim(str_replace('"', "'", $fileContents));
		
					$simpleXml = simplexml_load_string($fileContents);
					$json = json_encode($simpleXml);
		
					$phpArray = json_decode($json, true);
		
					if ($phpArray['tran']['result'] == 1){
						return $phpArray['tran']['message'];
					}else{
		
						$clrKey = "";
						
						$splitTID = str_split($phpArray['tran']['macros_tid']);
						$key = explode('|', $phpArray['tran']['message']);
						foreach ($splitTID as $tidChar) {
							if (!is_numeric($tidChar))
								$tidChar = 7;
		
							$clrKey .= substr($key[1], $tidChar, 1);
		
						}
		
						$clrKey = hex2bin($clrKey);
						$passHash = hash('SHA256', $clrKey.$usr->password2);
						$hexPass = hex2bin($passHash);
						$hashPin = hash('SHA256', $hexPass.$usr->pin);
						$client = new \GuzzleHttp\Client();
						$res = $client->post("http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_PIN_UPDATE&termid=".$termid."&userid=".$userid."&pin=".$hashPin."&control=PIN_RESET");
						\Log::info("TAMS RESPONSE AFTER PIN CHANGE ".$res->getBody());  
						
						$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody());
						$fileContents = trim(str_replace('"', "'", $fileContents));
			
						$simpleXml = simplexml_load_string($fileContents);
						$json = json_encode($simpleXml);
			
						$phpArray = json_decode($json, true);
			

						if ($res->getStatusCode() == 200) {
							if ($phpArray['tran']['result'] == 1){
								return $phpArray['tran']['message'];
							}
							else
							{
								return "success";
							}
						}
				  	}
				  }catch(\Exception $ex)
				  {
					\Log::error(__METHOD__.' PIN RESET ERROR '.$ex->getMessage());
				  }
				\Session::put('PASSWORD_CHANGED', 'changed');
				return "success";
			}
		}
		
	}



	/*VERIFY REFERRAL CODE*/
	public function verifyNewReferral(Request $req){
		/*INIT*/
		$client = new \GuzzleHttp\Client();
		$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid='.$req->code.'&userid=ernest.uduje@iisysgroup.com&control=INIT');
		if ($res->getStatusCode() == 200) {
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
			$fileContents = trim(str_replace('"', "'", $fileContents));
			$simpleXml = simplexml_load_string($fileContents);
			$json = json_encode($simpleXml);
			$phpArray = json_decode($json, true);

			if (array_key_exists('tran', $phpArray)) {
				if ($phpArray['tran']['result'] == "0") {
					$req->session()->put('referral', $req->code);
					return response()->json(['status' => 1, 'msg' => 'Referral verified successfully']);
				}else{
					return response()->json(['status' => 0, 'msg' => 'Invalid referral code']);
				}
			}else{
				if (array_key_exists('errcode', $phpArray)) {
					return response()->json(['status' => 0, 'msg' => 'Invalid referral code']);
				}
			}

		}
	}

}
