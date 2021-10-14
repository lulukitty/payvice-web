<?php
/**
 * Author: Emmanuel Paul (Nonye)
 */

namespace App\Http\Controllers;

use App\Account;
use GuzzleHttp\Psr7;
use App\Utils\RequestRules;
use Illuminate\Http\Request;

use App\Helpers\HttpStatusCodes;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelperController;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\VasFourOperations;

class IBEController extends Controller
{
    protected $helper;
    protected $client;

    public function __construct()
    {
        $this->helper = new HelperController;
        $this->vasOperations = new VasFourOperations;
    }

    /***
     * Ibadan Electric Distribution Company 
     * This method validates meter number 
     */

    public function meterLookup(Request $request){
        
        if(isset($request->view)){
            $params = $request->all();
        } else {
            $params = json_decode($request->getContent(), true);
        }
    
        $validator =  Validator::make($request->all(), RequestRules::getRule('IBADAN_ELECTRIC_LOOKUP'));
        if($validator->fails()) {
            if(isset($params['view'])){
                $errorResponse = $this->validationError($validator->getMessageBag()->all());
                return $this->displayValidationError($errorResponse);
            } else {
                return $this->validationError($validator->getMessageBag()->all(), HttpStatusCodes::BAD_REQUEST);
            }
        }
        // Get Session Key
        $sessionKey = $this->sessionKey($request);
        $clientReference = $this->helper->uniqueClientReference($request);
            
        \Log::info("Ibedc validation Params". print_r($params, true));

        $jsonParams = [
            "meterNo" => $params['meter'],
            "accountType" => $params['service'],
            "service" => "ibedc",
            "amount" => $params['amount'],
            "channel" => "WEB"
        ];

        $headers = $this->vasOperations->getVasHeaders($jsonParams);
        $parameters = [
            'json' => $jsonParams,
            'headers' => $headers
        ];

        \Log::info("IBEDC Validation Payment Params being sent to Vas 4.0: ". print_r($parameters, true));


        try {
            // Create a new Instance of Http Client Resource
            $responseValidation = $this->guzzleClient()->request('POST', $this->vasOperations->vasUrl.'/v1/vas/electricity/validation', $parameters);

            $responseValidationData = $this->responseToArray($responseValidation);
            \Log::info("IBEDC Validation Direct Response ". print_r($responseValidationData, true));
                
            if($responseValidationData['responseCode'] == "00"){
                $responseValidationData['data']['meterNumber'] = $params['meter'];
                $responseValidationData['data']['service'] = $params['service'];

                if(isset($request->view)){
                    $status = true;
                    $data = $this->mailTemplate('ibedc_payment',$responseValidationData['data']);
                    return $this->returnHtmlOutput($status,$data);
                } else {
                    $msg = $responseValidationData['message'];
                    $data = $responseValidationData['data'];
                    return $this->jsonoutput($msg, $data, HttpStatusCodes::OK);
                }

            } else {
                if(isset($request->view)){
                    $status = false;
                    $data = $responseValidationData['message'];
                    return $this->returnOutput($status,$data);
                } else {
                    $data = $responseData['data'];
                    return $this->validationError($data, HttpStatusCodes::NOT_FOUND);
                }
            }
            
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                \Log::info("Ibedc Validation Exception ". print_r($errorMsg, true));
                return $errorMsg;
            }
        } catch (ConnectException $e) {
            if ($e->hasResponse()) {
                $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                \Log::info("Ibedc Validation Exception ". print_r($errorMsg, true));
                return $errorMsg;
            }
        }

    }

    public function payUtility(Request $request){
        if(isset($request->view)){
            $params = $request->all();
        } else {
            $params = json_decode($request->getContent(), true);
        }

        $sessionKey = $this->sessionKey($request);
        $clientReference = $this->helper->uniqueClientReference($request);
        $userDetails = $this-> getUserDetails($request);

        $params['amount'] = $params['xdata'][0];
        $params['phone'] = $params['xdata'][1]; 
        $params['pin'] = $params['xdata'][2];
        //dd($params);
        $userPin = $params['pin'];
        $encryptedPin = Account::getEncryptedPin($userPin);
        if(isset($params['amount'])){
            $amount = (int) $params['amount'] * 100; // In Naria
        }

        if($params['type'] == "prepaid"){
            $type = "token";
        } else {
            $type = "postpaid";
        }

        $jsonParams = [
            "wallet" => $userDetails['wallet_id'],
            "username" => $userDetails['email'],
            "password" => $userDetails['password'],
            "pin" => $encryptedPin,
            "type" => "getcus",
            "type" => $type,
            "account" => $params['meter'],
            "phone" => $params['phone'],
            "productCode" => $params['productCode'],
            "customerName" => $params['name'],
            "paymentMethod" => "cash",
            "amount" => $amount,
            "clientReference" =>  $clientReference,
            "channel" => "WEB"
        ];
        
        try {
            $response = $this->guzzleClient()->request('POST', HttpRequests::baseURI().'/vas/ibedc/payment', [
                'json' => $jsonParams,
                'headers' => HttpRequests::httpHeaders()
            ]);
            $responseData = $this->responseToArray($response);
            
            // Requery Transaction
            $transactionStatus =  $this->helper->requeryTransaction($userDetails, $responseData['reference']);
            //dd($responseData, $jsonParams,$transactionStatus);
            //dd($transactionStatus);
            if($transactionStatus == true){
                if(isset($request->view)){
                    if($type == "postpaid"){
                        $msg = "Payment Status: ". $responseData['message']. "";
                    } else {
                        $msg = "Status: ". $responseData['message']. "; PayRef: ". $responseData['reference']. "; Amount Paid: &#8358;". $responseData['amount']/100 ."; TOKEN: ".$responseData['token'] . " Unit: ". $responseData['tokenDetails']['kwH'];
                    }
                    
                    $status = true;
                    $data = $msg;
                    return $this->returnOutput($status,$data);

                } else {
                    $msg = $responseData['message'];
                    $data = $responseData;
                    return $this->jsonoutput($msg, $data, HttpStatusCodes::OK);
                }

            } elseif($transactionStatus == false) { 

                if(isset($request->view)){
                    $msg = "Transaction Failed. Please Try Again";
                    $status = false;
                    $data = $msg;
                    return $this->returnOutput($status,$data);
                } else {
                    $data = $responseData['message'];
                    return $this->validationError($data, HttpStatusCodes::OK);
                }

            } elseif($transactionStatus == null) {
                if(isset($request->view)){
                    $msg = "Invalid or Expired Transaction";
                    $status = false;
                    $data = $msg;
                    return $this->returnOutput($status,$data);
                } else {
                    $data = $responseData['message'];
                    return $this->validationError($data, HttpStatusCodes::OK);
                }
            }

        } catch (RequestException | ErrorException $e) {
            if ($e->hasResponse()) {
                if(isset($request->view)){
                    $status = false;
                    $data = "An error occured during the request process. Please contact ITEX for more clarity.";
                    return $this->returnOutput($status,$data);
                } else {
                    $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                    return $errorMsg;
                }
            }
        }
    }

    private function mailTemplate($template,$data)
    {
        $contents = view('renders.'.$template, $data)->render();
        return $contents;
    }

}