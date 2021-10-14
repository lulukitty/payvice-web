<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \GuzzleHttp;
use \GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\VasFourOperations;

class Account extends Model
{

    public static function login($userEmail, $userPassword, $internal = false){

    	$response['status'] = 2;
    	$response['message'] = "Unable to login. Please check details and try again";

    	try {

    		$client = new GuzzleHttp\Client([
                'verify' => false
            ]);
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

                            $response['wallet'] = $usrTID ?? null;

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

    						$login =  new GuzzleHttp\Client([
                                'verify' => false
                            ]);
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


    							if ($phpArray['tran']['result'] == 0){
    								//return $phpArray['tran']['message'];

    								$userData = explode("|", $phpArray['tran']['message']);

    								$userCredentials = [
                                        'email' => $userData[5] ?? '',
                                        'name' =>  str_replace("<macros>", "", $userData[0] ?? ''),
                                        'account' => $userData[2] ?? ''
                                    ];

                                    $response['status'] = 1;
                                    $response['message'] = "Login Successful";
                                    $response['userDetails'] = $userCredentials;

                                    if($internal === true){
                                      $response['encryptedPassword'] = $encryptedPassword;
                                  }

                              } else {

                                $response['message'] = $phpArray['tran']['message'] ?? "Unable to login. Please check details and try again";

                            }


                        }

                    }
                }

            } catch (Exception $e) {

              $response['status'] = 3;
              $response['message'] = "Unable to login. Please check details and try again";


          }

          return (object) $response;

      }

      public static function getEncryptedPin($plainPin, $password = null){

        if($password == null){

            $password = session('usrKeyPass') ?? '';
            
        }

        $encryptedPassword = hex2bin($password) ?? false;

        if($encryptedPassword !== false){

          return hash('SHA256', $encryptedPassword.$plainPin);

      }

      return false;
  }


  public static function balance($walletId, $userEmail){

   $response['status'] = 2;
   $response['message'] = "Unable to check balance. Please try again";

   try {

    $client = new GuzzleHttp\Client([
        'verify' => false
    ]);

    $res = $client->post('http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=BALANCE&termid='.$walletId.'&userid='.$userEmail);

    if ($res->getStatusCode() == 200) {
     $fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
     $fileContents = trim(str_replace('"', "'", $fileContents));
     $simpleXml = simplexml_load_string($fileContents);
     $json = json_encode($simpleXml);
     $phpArray = json_decode($json, true);


     Log::info('ACCOUNT BALANCE FROM TAMS', [$phpArray]);

     $getBalance = $phpArray;

     $balanceArray = explode('N', $getBalance['tran']['balance']);

    //  $balance =  $balanceArray[1] ?? 0;

    //  $balance = (double) str_replace(",", "", $balance);
    $vasFourOperations = new VasFourOperations();
    $balance = $vasFourOperations->getWalletBalance($walletId, $userEmail);

    			//Check if Commission Balance Exists
     $commissionBalance = 0;
     if(isset($getBalance['tran']['commission'])) {
        $commissionBalanceArray = explode('N', $phpArray['tran']['commission']);

        $commissionBalance = $commissionBalanceArray[1] ?? 0;
        $commissionBalance = (double) str_replace(",", "", $commissionBalance);

    }

    $response['status'] = 1;
    $response['message'] = "Successfully retrieved balance";
    $response['balance'] = $balance;
    $response['commission'] = $commissionBalance;
}

} catch (\Exception | RequestException $e) {

    Log::info('========= BALANCE CHECK EXCEPTION =============', [$e]);

    $response['status'] = 3;
    $response['message'] = "Unable to check balance. Please try again";

}

return (object) $response;

}

public function walletLookup($walletID){

    $response['status'] = 2;
    $response['message'] = "Unable to fetch wallet details. Please try again";

    try {

        $client = new GuzzleHttp\Client([
            'verify' => false
        ]);

        $res = $client->post("http://197.253.19.75/tams/eftpos/devinterface/UsableEngines/wallet-lookup.php?walletID=$walletID");

        if ($res->getStatusCode() == 200) {

            $theirResponse = $res->getBody()->getContents();

            $lookup = json_decode($theirResponse);

            if(isset($lookup->status) && isset($lookup->error) && isset($lookup->name) && $lookup->status == 1 && $lookup->error == false){

                $response['status'] = 1;
                $response['message'] = "Lookup Successful";
                $response['wallet'] = $walletID;
                $response['user'] = $lookup->name;

            } else {

                $response['status'] = 4;
                $response['message'] = "Lookup failed";

            }



        }

    } catch (\Exception | RequestException $e) {

        $response['status'] = 3;
        $response['message'] = "Lookup failed. Please try again";

    }

    return (object) $response;

}

public static function formatTAMSBalance($tamsBalance){

    $balanceArray = explode('N', $tamsBalance);

    $theBalance = $balanceArray[1] ?? 0;

    $theNairaBalance = (double) trim((str_replace(",", "", $theBalance)));

    $theKoboBalance = $theNairaBalance * 100;

    return [
        'nairaBalance' => $theBalance,
        'balance' => $theKoboBalance,
    ];

}


public static function walletTransfer($userID, $walletId, $beneficiary, $amount, $pin){

    $response['status'] = 2;
    $response['message'] = "Unable to transfer. Please try again";

    try {

        $client = new GuzzleHttp\Client([
            'verify' => false
        ]);

        $requestUrl = "http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&termid=$walletId&userid=$userID&control=Transfer&recipient_terminal_id=$beneficiary&amount=$amount&pin=$pin";

            //dd($requestUrl);

        $res = $client->get($requestUrl);


        if ($res->getStatusCode() == 200) {
            $fileContents = str_replace(array("\n", "\r", "\t"), '', $res->getBody()->getContents());
            $fileContents = trim(str_replace('"', "'", $fileContents));
            $simpleXml = simplexml_load_string($fileContents);
            $json = json_encode($simpleXml);
            $phpArray = json_decode($json, true);

            $theirResponse = $phpArray;

            //dd($theirResponse);

            if( isset($theirResponse['tran']['result']) && isset($theirResponse['tran']['status']) && $theirResponse['tran']['result'] == 0 && $theirResponse['tran']['status'] == 1){

                $response['status'] = 1;
                $response['message'] = "Transfer Successful";
                $response['amount'] = $amount;
                $response['beneficiary'] = $beneficiary;

                $balance = $theirResponse['tran']['balance'] ?? '';
                $commission = $theirResponse['tran']['commission'] ?? '';

                $debitReference = $theirResponse['tran']['FRREF'] ?? '';
                $creditReference = $theirResponse['tran']['TOREF'] ?? '';

                $theBalance = static::formatTAMSBalance($balance);

                $response['balance'] = $theBalance['balance'];
                $response['reference'] = $debitReference;
                $response['beneficiaryReference'] = $creditReference;

            } else {

                $response['status'] = 4;
                $response['message'] = "Transfer failed";

            }



        }

    } catch (\Exception | RequestException $e) {

        $exceptionDetails = [
            'message' => $e->getMessage(),
            'file' => basename($e->getFile()),
            'line' => $e->getLine(),
            'type' => class_basename($e)
        ];

        \Log::error("An Exception Occured in the account transfer service: " . print_r($exceptionDetails, true));

        //dd($exceptionDetails);

        $response['status'] = 3;
        $response['message'] = "Unable to transfer. Please try again";


    }

    return (object) $response;
}


public static function transactionHistory($viewWallet, $viewProduct, $startDate, $endDate, $limit, $currentPage){
    $response['status'] = 0;
    $response['message'] = "Failed";

    $encryptedPassword = session('usrKeyPass') ?? false;
    $clearPassword = session('clearPass') ?? false;
    $userEmail = session('curEm');
    $walletID = session('curAcc');

    //return $encryptedPassword;

    $body['walletId'] = $walletID;
    $body['username'] = $userEmail;
    $body['password'] = $clearPassword;
    $body['viewWallet'] = $viewWallet;
    $body['product'] = $viewProduct === 'ALL' ? '' : $viewProduct;
    $body['startDate'] = str_replace("-", "/", $startDate);
    $body['endDate'] = str_replace("-", "/", $endDate);
    $body['limit'] = $limit;
    $body['currentPage'] = $currentPage;

    $client = new GuzzleHttp\Client([
        'verify' => false,
    ]);

    $apiUrl = "http://197.253.19.76:8004/api/v1/payvice/transaction/details";

    $header = [
        'Content-Type' => 'application/json',
    ];

    $parameters = [
        'json' => $body,
        'headers' => $header,
    ];

    try {
        $clientResponse = $client->request('POST', $apiUrl, $parameters);
        $code = $clientResponse->getStatusCode();
        \Log::info("Status Code from Transaction History" . print_r($code, true));
        if ($code == 200) {
            $jsonResponse = $clientResponse->getBody()->getContents();
            $response = json_decode($jsonResponse);

        }

    } catch (\Exception | RequestException $e) {

        if (method_exists($e, 'hasResponse') && $e->hasResponse()) {
            $theirResponseCode = $e->getResponse()->getStatusCode();
            $theirResponse = $e->getResponse()->getBody()->getContents();
            $theirResponseHeaders = $e->getResponse()->getHeaders();
            $response['responseType'] = "exception";
        } else {

            $response['status'] = 2;

            $response['process'] = "A request exception might have occured";

            $response['message'] = "There was an exception";

        }

        \Log::info("Transaction History Exception " . print_r($theirResponse, true));

        $response['status'] = 2;
        $response['error'] = "An exception occured";
        $response['responseStatusCode'] = $theirResponseCode ?? 500;
        $response['response'] = $theirResponse ?? '';
        $response['responseHeaders'] = $theirResponseHeaders ?? '';

    }

    return $response;

}

public static function fetchProducts(){
    try {
        $client = new GuzzleHttp\Client([ 'verfy' => false]);
        $response = $client->request('GET', "http://vas.itexapp.com/vas/get-products");

        if($response->getStatusCode() == 200){
            $productList = json_decode($response->getBody()->getContents());
        }else {
            $productList = '';
        }
    } catch (\Throwable $th) {
        $productList = '';
    }

    return $productList;
}

public static function ft_transactionHistory($viewWallet, $viewProduct, $startDate, $endDate, $limit, $currentPage){

    $response['status'] = 0;
    $response['message'] = "Failed";

    $encryptedPassword = session('usrKeyPass') ?? false;
    $clearPassword = session('clearPass') ?? false;
    $userEmail = session('curEm');
    $walletID = session('curAcc');

        //return $encryptedPassword;

    $body['wallet'] = $walletID;
    $body['username'] = $userEmail;
    $body['password'] = $clearPassword;
    $body['viewWallet'] = $viewWallet;
    $body['product'] = $viewProduct;
    $body['startDate'] = $startDate;
    $body['endDate'] = $endDate;
    $body['limit'] = $limit;
    $body['currentPage'] = $currentPage;

    $client = new GuzzleHttp\Client([
        'verify' => false,
    ]);

    $apiUrl = "http://197.253.19.76:8004/api/v1/payvice/transaction/history";

    $header = [
        'Content-Type' => 'application/json'
    ]; 

    $parameters = [
        'json' => $body,
        'headers' => $header,
    ];

    try {
        $clientResponse = $client->request('POST', $apiUrl, $parameters);
        $code = $clientResponse->getStatusCode();
        \Log::info("Status Code from Transaction History" . print_r($code, true));
        if($code == 200){
            $jsonResponse = $clientResponse->getBody()->getContents();
            $theirResponse = json_decode($jsonResponse);
            //dd($theirResponse);
            if($theirResponse->status === 200){

                $response['status'] = 1;
                $response['message'] = "Successful";

            }

            $response['transactionHistory'] = $theirResponse;

        }

    } catch (\Exception | RequestException $e) {

        
        if (method_exists($e, 'hasResponse') && $e->hasResponse()) {
            $theirResponseCode = $e->getResponse()->getStatusCode();
            $theirResponse = $e->getResponse()->getBody()->getContents();
            $theirResponseHeaders = $e->getResponse()->getHeaders();
            $response['responseType'] = "exception";
        } else {

            $response['status'] = 2;

            $response['process'] = "A request exception might have occured";

            $response['message'] = "There was an exception";

        }

        \Log::info("Transaction History Exception " . print_r($theirResponse, true));

        $response['status'] = 2;
        $response['error'] = "An exception occured";
        $response['responseStatusCode'] = $theirResponseCode ?? 500;
        $response['response'] = $theirResponse ?? '';
        $response['responseHeaders'] = $theirResponseHeaders ?? '';


    }

    return $response;



}


}
