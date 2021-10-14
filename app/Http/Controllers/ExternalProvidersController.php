<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ExternalProvider, Carbon\Carbon;

class ExternalProvidersController extends Controller
{
    //

	public function __construct(){
		$this->termId = '203301ZA';
		$this->deviceId = '0123456789';
		$this->defaultPassword = "1234";
	}

	public function signup($providerKey){

    	//dd(md5("MWHOTsecret") . "extProvider");

		if($providerKey == "aaadd4035ac088664be1af83d556d1d0extProvider"){

			$response['status'] = 0;
			$response['message'] = "There was an error";
			$response['date'] = date("Y-m-d H:i:s");
			$response['errors'] = [];

			$theRequest = json_decode(request()->getContent(), true);

			$validator = \Validator::make($theRequest, [
				'name' => 'required|string|min:3',
				'email' => 'required|email'
			]);

			if ($validator->fails()){
				$response['status'] = 2;
				$response['message'] = "Invalid Request";	
				$response['errors'] = $validator->errors();
			}
			else{
				$email = $theRequest['email'];
				$username = $theRequest['name'];

				$hash = hash('sha512', utf8_encode($this->termId.$email.$username), false);

				$regUser = "?action=TAMS_REG&termid=".$this->termId."&userid=".$email."&username=".$username."&email=".$email."&device_id=".$this->deviceId."&key=".$hash;
				$client = new \GuzzleHttp\Client();

				$processContent = "";

				try {

									$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php'.$regUser);

									if ($res->getStatusCode() == 200) {
										$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
										$fileContents = trim(str_replace('"', "'", $fileContents));
										$processContent = $fileContents;

										$simpleXml = simplexml_load_string($fileContents);
										$json = json_encode($simpleXml);

										$phpArray = json_decode($json, true);

										if ($phpArray['tran']['result'] == 1){
					    				//return $phpArray['tran']['message'];
										}else{

											$clrKey = "";

											$splitTID = str_split($phpArray['tran']['macros_tid']);
											$key = explode('|', $phpArray['tran']['key']);
											foreach ($splitTID as $tidChar) {
												if (!is_numeric($tidChar))
													$tidChar = 7;

												$clrKey .= substr($key[1], $tidChar, 1);

											}

					    				/*$req->session()->put('clr', $clrKey);
					    				$req->session()->put('userTID', $phpArray['tran']['macros_tid']);
					    				$req->session()->put('userEmail', $email);*/

					    				$response['status'] = 1;
					    				$response['message'] = "Signup successful, please check your email for your verification code";
					    				$response['key'] = $clrKey;
					    				$response['terminalID'] =  $phpArray['tran']['macros_tid'];
					    				$response['email'] = $email;

					    				//return "success";

					    				
					    			}

					    		}

				} catch (\Exception $e) {

					$response['status'] = 3;
					$response['message'] = "Unable to signup. Please check details and try again later";
					$response['errors']['process'] = $processContent;

				}

				$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php'.$regUser);

				


    	}


    	

    	return json_encode($response);

    }

}

public function verify($providerKey){

	if($providerKey == "aaadd4035ac088664be1af83d556d1d0extProvider"){

		$response['status'] = 0;
		$response['message'] = "There was an error";
		$response['date'] = date("Y-m-d H:i:s");
		$response['errors'] = [];

		$theRequest = json_decode(request()->getContent(), true);

		$validator = \Validator::make($theRequest, [
			'email' => 'required|email',
			'terminalID' => 'required|string|min:4',
			'key' => 'required|string|min:1',
			'password' => 'required|string|min:8',
			'pin' => 'bail|required|min:4|max:4',
			'verificationCode' => 'bail|required|min:4|max:4',
		]);

		if ($validator->fails()){
			$response['status'] = 2;
			$response['message'] = "Invalid Request";	
			$response['errors'] = $validator->errors();
		}
		else {
			$clrKey = hex2bin($theRequest['key']);
			$termId = $theRequest['terminalID'];
			$userEmail = $theRequest['email'];
			$userPin = $theRequest['pin'];
			$userPassword = $theRequest['password'];
			$referralCode = "";

			$passHash = hash('SHA256', $clrKey.$userPassword);
			$hexPass = hex2bin($passHash);
			$hashPin = hash('SHA256', $hexPass.$userPin);


			$completion = "action=TAMS_PIN_UPDATE&termid=".$termId;
			$completion .= "&userid=".$userEmail."&password=".$this->defaultPassword."&newpassword=".$passHash;
			$completion .= "&vercode=".$theRequest['verificationCode']."&pin=1234&newpin=".$hashPin;
			$completion .= "&referalcode=".$referralCode;

			$processContent = "";

			try {

				$client = new \GuzzleHttp\Client();
				$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?'.$completion);

				if ($res->getStatusCode() == 200) {
					$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
					$fileContents = trim(str_replace('"', "'", $fileContents));
					$processContent = $fileContents;

					$simpleXml = simplexml_load_string($fileContents);
					$json = json_encode($simpleXml);

					$phpArray = json_decode($json, true);

					if ($phpArray['tran']['result'] == 0) {
				    				//return "success";

						$response['status'] = 1;
						$response['message'] = "Registration complete, please login";

					}else{
				    				//return "Could not complete registration. Please try again";

						$response['status'] = 3;
						$response['message'] = "Unable to complete registration. Please try again";

					}
				}

			} catch (\Exception $e) {
				
				$response['status'] = 3;
				$response['message'] = "Unable to complete registration. Please check details and try again";
				$response['errors']['process'] = $processContent;

			}

			


		}

		return json_encode($response);

	}

}


public function login($providerKey){

	if($providerKey == "aaadd4035ac088664be1af83d556d1d0extProvider"){

		$response['status'] = 0;
		$response['message'] = "There was an error";
		$response['date'] = date("Y-m-d H:i:s");
		$response['errors'] = [];

		$theRequest = json_decode(request()->getContent(), true);

		$validator = \Validator::make($theRequest, [
			'email' => 'required|email',
			'password' => 'required|string|min:8',
		]);

		if ($validator->fails()){
			$response['status'] = 2;
			$response['message'] = "Invalid Request";	
			$response['errors'] = $validator->errors();
		}
		else {

			$userEmail = $theRequest['email'];
			$userPassword = $theRequest['password'];

			$processContent = "";

			try {

				$client = new \GuzzleHttp\Client();
				$res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid=203301ZA&userid='.$userEmail.'&control=INIT');
						if ($res->getStatusCode() == 200) {
							$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
							$fileContents = trim(str_replace('"', "'", $fileContents));
							$processContent = $fileContents;
							$simpleXml = simplexml_load_string($fileContents);
							$json = json_encode($simpleXml);
							$phpArray = json_decode($json, true);

							/*print_r($phpArray);
							exit();*/


							if ($phpArray['tran']['result'] == 1) {
								//return $phpArray['tran']['message'];
								$processContent = $phpArray['tran']['message'];
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
								$pass = $hex.$userPassword;


								$encryptedPassword = hash('SHA256', $pass);

								//$usr->session()->put('usrKeyPass', $encryptedPassword);

								/*echo $encryptedPassword.'<br> >>>>>'.$createClrKey;
								exit();*/

								$login = new \GuzzleHttp\Client();
								$res = $login->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid='.$usrTID.'&userid='.$userEmail.'&password='.$encryptedPassword);
								if ($res->getStatusCode() == 200) {
									$fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
									$fileContents = trim(str_replace('"', "'", $fileContents));
									$processContent = $fileContents;
									$simpleXml = simplexml_load_string($fileContents);
									$json = json_encode($simpleXml);
									$phpArray = json_decode($json, true);

									/*print_r($phpArray);
									exit();*/


									if ($phpArray['tran']['result'] == 1){
										//return $phpArray['tran']['message'];
										$processContent = $phpArray['tran']['message'];
									}

									$userData = explode("|", $phpArray['tran']['message']);

									$userCredentials = [
									'email' => $userData[5],
									'name' =>  $userData[0],
									'account' => $userData[2]
									];

									/*$name = explode('<macros>', $userData[0]);

									$usr->session()->put('curUsr', $name[0]);
									$usr->session()->put('curAcc', $userData[2]);
									$usr->session()->put('curEm', $userData[5]);



									return "success";*/

									$tokenDetails['email'] = $userData[5];
									$tokenDetails['tid'] = $usrTID;
									$tokenDetails['acc'] = $userData[2];
									$tokenDetails['name'] = $userData[0];
									$tokenDetails['enc'] = $encryptedPassword;
									$tokenDetails['key'] = "";

									$theToken = ExternalProvider::generateToken($tokenDetails);
									if($theToken['status'] == 1){
										$response['status'] = 1;
										$response['message'] = "Login Successful";
										$response['userCredentials'] = $userCredentials;
										$response['token'] = $theToken['jwt'];
										$response['expiry'] = $theToken['expiry'];
									}

									

								}

							}
						}

			} catch (Exception $e) {
				
				$response['status'] = 3;
				$response['message'] = "Unable to login. Please check details and try again";
				$response['errors']['process'] = $processContent;

			}

			


		}

		return json_encode($response);

	}
		$vTokenDetails['jwt'] = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.Um5aMWRsVnRZWEpDTnpGb1ZtRk9VRGh5WmtWek9GSlZZbFJ2V0V3M1pURjRMMFEyWVdWc1RFOW9VMFozY1ZsbGFuSlhja05NV1U5R1JUZG1VRmRNY25GQmEyOURWMFV4Y1VaUllXeFlURGRwV1UxUGJHWlRWazkxZFhrNFJYTkhMMkUzYWpWWFl6TjNWRU5PZGpJeWFISnRWSEp4WkUxQmF6RjNTMjVYTm5ac2NtRnVRelp4ZGpacVlXbERjMWRXTDBGT1QzTjVkbEUzYWs1VVRFdEVhREpIZG5sTlkyMWtXbFZ2THk5V2FXWnNVRTFqZWxOR1YwWnpWM1JGTnpJeWVGaFlXRmNyT0VFcmFqSjRZbGxFVEZwRlJFUlhibTlyU0ZncmVtYzRUamhWWTJreWRFWkVPRTA0YW5ORmFWRkpZbVZVVHpkdGJYZElUR0kyVmsxNVlVRk9TWFZQTm00emMzbDJRMk5xY1ZoTlVscHFVMjAzUjJrdlYxaHRSSGhrVkU5dVpsZzBaQzl4VGk5bFdGSktSRElyUXk5a2NIWk5LMWhDZW10RU9EbExNMkkwUkZWdldsSjZkVVJQUlhwak5tbHhlamN6V25jelRGWTJNRko0ZEd4MVdYUXpaaTk1WVVaRlBRPT0.1d9e028fb2583de87b25dae3d3caa13626bd819b1858722c69e0c4fd056d7f85";
	//dd(ExternalProvider::validateToken($vTokenDetails));

}

}
