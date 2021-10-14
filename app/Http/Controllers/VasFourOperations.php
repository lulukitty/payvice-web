<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\HelperController;

class VasFourOperations extends Controller
{
    public $apiKey;
    public $apiIdentifier;
    public $client;
    public $vasUrl;
    public $requeryUrl;

    public function __construct(){

        $this->helper = new HelperController;

        //live
        $this->apiKey = "b83cef088a4943231342c7fd53b6502d";
        $this->apiIdentifier = "itexlive";
        $this->client = new \GuzzleHttp\Client([ 'verify' => false ]);
        $this->vasUrl = 'http://197.253.19.76:8019/api';
        $this->requeryUrl = 'http://197.253.19.76:8008/api/v1/vas/storage/fetch/transaction';

        //test
        // $this->apiKey = "n6D6nbUURFbafb27kNxmbODqLSge9pXP";
        // $this->apiIdentifier = "itex";
        // $this->client = new \GuzzleHttp\Client([ 'verify' => false ]);
        // $this->vasUrl = 'http://197.253.19.76:1880/api';
        // $this->requeryUrl = 'http://197.253.19.76:8006/api/v1/vas/storage/fetch/transaction';

        //live on test
        // $this->apiKey = "7d4bc40e0ba045d49cfe6b24eab42f56";
        // $this->apiIdentifier = "wincodes";
        // $this->client = new \GuzzleHttp\Client([ 'verify' => false ]);
        // $this->vasUrl = 'http://197.253.19.76:8018/api';
        // $this->requeryUrl = 'http://197.253.19.76:8006/api/v1/vas/storage/fetch/transaction';
    }

    public function getWalletBalance($walletId, $userEmail){
        try {
            $jsonParams = [
                "wallet" => $walletId,
                "username" => $userEmail
            ];

            $headers = $this->getVasHeaders($jsonParams);

            $response = $this->client->request('POST', $this->vasUrl.'/vas/wallet/balance', [
                'json' => $jsonParams,
                'headers' => $headers
            ]);

            $responseData = $this->responseToArray($response);
            \Log::info("Get Api Token response: ". print_r($responseData, true));

            if($responseData['responseCode'] == "00"){
                return $responseData['data']['balance'];
            }

            return null;
                        
        } catch (RequestException $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
                'type' => class_basename($e),
                'body' => $e->getResponse()->getBody()->getContents()
            ];

            $resDetails = [
                'responseCode' => "99",
                "message" => $exceptionDetails['message']
            ];

            \Log::info("Get Auth Api Exception: ". print_r($exceptionDetails, true));
            $body = $exceptionDetails['body'] == null ? null : json_decode($exceptionDetails['body'], true);
            $message = $body == null ? $resDetails :  $body;

            // return response()->json(['status' => "failed", 'message' => $message ], 400);   

            return null;
        }
    }

    public function getAuthToken ($wallet, $username, $password){        
        

            $header = [
                'Content-Type' => 'application/json',
            ];

            $params = [
                "wallet" => $wallet,
                "username" => $username,
                "password" => $password,
                "identifier" => $this->apiIdentifier
            ];

            try {

                $response = $this->client->request('POST', $this->vasUrl.'/vas/authenticate/me', [
                    'json' => $params,
                    'headers' => $header
                ]);

                $responseData = $this->responseToArray($response);
                \Log::info("Get Api Token response: ". print_r($responseData, true));
                
                return $responseData;
                            
            } catch (\Exception | RequestException $e) {
                if ($e->hasResponse()) {
                    $exceptionDetails = [
                        'message' => $e->getMessage(),
                        'file' => basename($e->getFile()),
                        'line' => $e->getLine(),
                        'type' => class_basename($e),
                        'body' => $e->getResponse()->getBody()->getContents()
                    ];

                    \Log::info("Get Auth Api Exception: ". print_r($exceptionDetails, true));
                    $body =  json_decode($exceptionDetails['body'], true); 

                    return $message;
                }
                
                $resDetails = [
                    'responseCode' => "99",
                    "message" => $e-getMessage()
                ];
                \Log::info("Get Auth Api Exception: ". print_r($resDetails, true));

                return $resDetails;
            }
    }

    public function requeryTransaction($clientReference){        
        

        $header = [
            'Content-Type' => 'application/json',
        ];

        $params = [
            "wallet" => session('curAcc'),
            "clientReference" => $clientReference,
        ];

        try {

            $response = $this->client->request('POST', $this->requeryUrl, [
                'json' => $params,
                'headers' => $header
            ]);

            $responseData = $this->responseToArray($response);
            \Log::info("Requery Response: ". print_r($responseData, true));
            
            return $responseData;
                        
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $exceptionDetails = [
                    'message' => $e->getMessage(),
                    'file' => basename($e->getFile()),
                    'line' => $e->getLine(),
                    'type' => class_basename($e),
                    'body' => $e->getResponse()->getBody()->getContents()
                ];
                \Log::info("Requery Exception: ". print_r($exceptionDetails['body'], true));
                $body = json_decode($exceptionDetails['body'], true);
                return $body;
            }else{
                $resDetails = [
                    'responseCode' => "99",
                    "message" => 'An Exception Occurred Please Contact Itex'
                ];

                \Log::info("Requery Exception: ".$e->getMessage());
                return $resDetails;
            }
        }
}

    public function getEncryptedPin($wallet, $username, $password, $pin){
        try {

            $header = [
                'Content-Type' => 'application/json',
            ];

            $params = [
                "wallet" => $wallet,
                "username" => $username,
                "password" => $password,
                "pin" => $pin
            ];

            $response = $this->client->request('POST', $this->vasUrl.'/vas/credentials/encrypt-pin', [
                'json' => $params,
                'headers' => $header
            ]);

            $responseData = $this->responseToArray($response);
            \Log::info("Encrypt Pin response: ". print_r($responseData, true));
            
            return $responseData;
                        
        } catch (RequestException $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
                'type' => class_basename($e),
                'body' => $e->getResponse()->getBody()->getContents() ?? null
            ];

            $resDetails = [
                'responseCode' => "99",
                "message" => $exceptionDetails['message']
            ];

            \Log::info("Get Auth Api Exception: ". print_r($exceptionDetails, true));
            $body = $exceptionDetails['body'] == null ? null : json_decode($exceptionDetails['body'], true);
            $message = $body == null ? $resDetails :  $body; 

            return $message;
        }
    }

    public function getVasHeaders($params){
        $encodedBody = json_encode($params, true);
        $hmac = hash_hmac("sha256", $encodedBody, $this->apiKey);

        return [
            "Token" => session('authToken'),
            "Signature" => $hmac
        ];
    }

    public function electricityValidation(Request $request){
        // return $request->all();
        $validator =  Validator::make($request->all(), [
            'service' => 'required',
            "meter" => "required",
            "accountType" => "required",
            "amount" => "required",
        ]);

        if($validator->fails()) {
            return response()->json(['status' => "failed", 'message' => "Please Fill all Required Fields" ], 400);
        }


        $jsonParams = [		
			"meterNo" => $request->meter,
            "accountType" => $request->accountType,
            "service" => $request->service,
            "amount" => $request->amount,
            "channel" => "WEB"
        ];

        $headers = $this->getVasHeaders($jsonParams);

        \Log::info("Data Params being sent to Vas 4.0: ". print_r($jsonParams, true));

        try {

            $response = $this->client->request('POST', $this->vasUrl.'/v1/vas/electricity/validation', [
                'json' => $jsonParams,
                'headers' => $headers
            ]);

            $responseData = $this->responseToArray($response);            
            \Log::info("Data Payment Response: ". print_r($responseData, true));

            if ($responseData['responseCode'] == "00"){
                session()->put('productCode',  $responseData['data']['productCode']);
                return response()->json(['status' => "Success", 'message' => $responseData['message'], 'data' =>  $responseData['data']  ], 200);
            }else{
                return response()->json(['status' => "failed", 'message' => $responseData['message'] ], 400);
            }

        } catch (\Exception | RequestException $e) {
            $exceptionDetails = [
                'message' => $e->getMessage(),
                'file' => basename($e->getFile()),
                'line' => $e->getLine(),
                'type' => class_basename($e),
                'body' => $e->getResponse()->getBody()->getContents()
            ];

            \Log::info("Data Purchase Exception: ". print_r($exceptionDetails, true));
            $body = json_decode($exceptionDetails['body'], true);

            return response()->json(['status' => "failed", 'message' => $body['message'] ], 400);   
        }
    }

    public function payElectricity(Request $request){
        $params = $request->all();

        $sessionKey = $this->sessionKey($request);
        $clientReference = $this->helper->uniqueClientReference($request);
        
        $userPin = $params['pin'];
        $encryptedPin = Account::getEncryptedPin($userPin);

        $jsonParams = [
            "pin" => $encryptedPin,
            "paymentMethod" => "cash",
            "channel" => "WEB",
            "productCode" => $params['productCode'],
            "service" => $params['service'],
            "customerPhoneNumber" => $params['phone'],
            "clientReference" =>  $clientReference
        ];

        $headers = $this->getVasHeaders($jsonParams);
        $parameters = [
            'json' => $jsonParams,
            'headers' => $headers
        ];
        \Log::info($params['service']." Payment Params being sent to Vas 4.0: ". print_r($parameters, true));
   
        try {
            $response = $this->client->request('POST', $this->vasUrl.'/v1/vas/electricity/payment', $parameters);
            $responseData = $this->responseToArray($response);
            //dd($responseData);
            \Log::info($params['service']." Payment Response from vas 4.0". print_r($responseData, true));
            if($responseData['responseCode'] == "00"){
                return response()->json([ 'data' => $responseData ], 200);
            } else {
                return response()->json([ 'data' => $responseData ], 400);
            }

        } catch (RequestException $e) {
           $requeryResponse =  $this->requeryTransaction($clientReference);
           if($requeryResponse['responseCode'] == "00"){
                \Log::info($params['service']." Successful Rerquery". print_r($requeryResponse, true));
                return response()->json([ 'data' => $requeryResponse ], 200);
           }else{
                if ($e->hasResponse()) {
                    $errorArr = $this->jsonToArray($e->getResponse()->getBody()->getContents());        
        
                    return response()->json([ 'data' => $errorArr, ], 400);
                }
                \Log::info($params['service']." Payment Eception from vas 4.0". $e->getMessage());
                $data = [ 'message' =>  'An Exception occurred, Please contact Itex' ];
                return response()->json([ 'data' => $data ], 400);
           }
        }
    }

    public function validateSmileAccount(Request $request){
		$params = $request->all();

        $jsonParams = [
            "type" => 'account',
            "account" => $params['card'],
            "channel" => "WEB",
            "service" => 'smile'
        ];

        $headers = $this->getVasHeaders($jsonParams);
        $parameters = [
            'json' => $jsonParams,
            'headers' => $headers
        ];
        \Log::info("Smile Validation Params being sent to Vas 4.0: ". print_r($parameters, true));
   
        try {
            $response = $this->client->request('POST', $this->vasUrl.'/v1/vas/internet/validation', $parameters);
            $responseData = $this->responseToArray($response);
            //dd($responseData);
            \Log::info("Smile Validation Response from vas 4.0". print_r($responseData, true));
            if($responseData['responseCode'] == "00"){
                //Get Bundles
                $bundles = $this->getSmileBundles($params);
                if($bundles == null){
                    $responseData['message'] = "Unable to Retrieve Bundles";
                    return response()->json([ 'data' => $responseData ], 400);
                }
                $responseData['data']['bundles'] = $bundles;
                return response()->json([ 'data' => $responseData ], 200);
            } else {
                return response()->json([ 'data' => $responseData ], 400);
            }

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorArr = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                \Log::info("Smile Validation Eception from vas 4.0". print_r($errorArr, true));
    
                return response()->json([ 'data' => $errorArr ], 400);
            }
            \Log::info("Smile Validation Eception from vas 4.0". $e->getMessage());
            $data = [ 'message' =>  'An Exception occurred, Please contact Itex' ];
            return response()->json([ 'data' => $data ], 400);
        }
    }
    
    public function getSmileBundles($params){
        $jsonParams = [
            "type" => 'account',
            "account" => $params['card'],
            "channel" => "WEB",
            "service" => 'smile'
        ];

        $headers = $this->getVasHeaders($jsonParams);
        $parameters = [
            'json' => $jsonParams,
            'headers' => $headers
        ];
        \Log::info("Smile Get Bundle Params being sent to Vas 4.0: ". print_r($parameters, true));
   
        try {
            $response = $this->client->request('POST', $this->vasUrl.'/v1/vas/internet/bundles', $parameters);
            $responseData = $this->responseToArray($response);
            
            \Log::info("Smile Get Bundle Response from vas 4.0". print_r($responseData, true));
            if($responseData['responseCode'] == "00"){
                return $responseData['data']['bundles'];
            } else {
                return null;
            }

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorArr = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                \Log::info("Smile Get Bundle Eception from vas 4.0". print_r($errorArr, true));
    
                return null;
            }
            \Log::info("Smile Get Bundle Eception from vas 4.0". $e->getMessage());
            return null;
        }
    }

    public function smilePayment(Request $request){
        $params = $request->all();
        
        $sessionKey = $this->sessionKey($request);
        $clientReference = $this->helper->uniqueClientReference($request);
        
        $userPin = $params['pin'];
        $encryptedPin = Account::getEncryptedPin($userPin);

        $jsonParams = [
            "type" => 'subscription',
            "phone" => $params['phone'],
            "code" => $params['selectedBundle'],
            "paymentMethod" => "cash",
            "service" => "smile",
            "clientReference" => $clientReference,
            "pin" => $encryptedPin,
            "productCode" => $params['productCode'],
            "channel" => "WEB"
        ];

        $headers = $this->getVasHeaders($jsonParams);
        $parameters = [
            'json' => $jsonParams,
            'headers' => $headers
        ];
        \Log::info("Smile Payment Params being sent to Vas 4.0: ". print_r($parameters, true));
   
        try {
            $response = $this->client->request('POST', $this->vasUrl.'/v1/vas/internet/subscription', $parameters);
            $responseData = $this->responseToArray($response);
            //dd($responseData);
            \Log::info("Smile Payent Response from vas 4.0". print_r($responseData, true));
            if($responseData['responseCode'] == "00"){
                return response()->json([ 'data' => $responseData ], 200);
            } else {
                return response()->json([ 'data' => $responseData ], 400);
            }

        } catch (RequestException $e) {
            $requeryResponse =  $this->requeryTransaction($clientReference);
            if($requeryResponse['responseCode'] == "00"){
                 \Log::info($params['service']." Successful Rerquery". print_r($requeryResponse, true));
                 return response()->json([ 'data' => $requeryResponse ], 200);
            }else{
                if ($e->hasResponse()) {
                    $errorArr = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                    \Log::info("Smile Payent Eception from vas 4.0". print_r($errorArr, true));
        
                    return response()->json([ 'data' => $errorArr ], 400);
                }
                \Log::info("Smile Payent Eception from vas 4.0". $e->getMessage());
                $data = [ 'message' =>  'An Exception occurred, Please contact Itex' ];
                return response()->json([ 'data' => $data ], 400);
            }
        }
    }
}