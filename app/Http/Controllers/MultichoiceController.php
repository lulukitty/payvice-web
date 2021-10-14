<?php

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

class MultichoiceController extends Controller
{
    protected $helper;
    protected $client;

    public function __construct()
    {
        $this->helper = new HelperController;
        $this->vasOperations = new VasFourOperations;
    }

    public function payMultichoice(Request $request){
        if(isset($request->view)){
            $params = $request->all();
        } else {
            $params = json_decode($request->getContent(), true);
        }

        $sessionKey = $this->sessionKey($request);
        $clientReference = $this->helper->uniqueClientReference($request);
        $userDetails = $this-> getUserDetails($request);

        $userPin = $params['pin'];
        $encryptedPin = Account::getEncryptedPin($userPin);

        if($params['unit'] == "STARTIMES"){
            $validator =  Validator::make($request->all(), RequestRules::getRule('STARTIMES_LOOKUP'));
            if($validator->fails()) {
                $data = [
                    'message' => $validator->getMessageBag()->all()
                ];
                return response()->json([ 'data' => $data ], 400);
            }

            $jsonParams = [
                "pin" => $encryptedPin,
                "channel" => "WEB",
                "service" => strtolower($params['unit']),
                "customerName" => $userDetails['username'],
                "phone" => $params['phone'],
                "productCode" => $params['productCode'],
                "bouquet" => $params['selectedBouquet'],
                "cycle" => $params['cycle'],
                "paymentMethod" => "cash",
                "clientReference" =>  $clientReference
            ];
        } else {
            $jsonParams = [
                'service' => 'multichoice',
                'channel' => 'WEB',
                "paymentMethod" => "cash",
                'code' =>  $params['product_code'],
                'phone' => $params['iuc'],
                'productCode' => session('productCode'),
                'clientReference' => $clientReference,
                'pin' => $encryptedPin
            ];
        }

        $headers = $this->vasOperations->getVasHeaders($jsonParams);
        $parameters = [
            'json' => $jsonParams,
            'headers' => $headers
        ];

        \Log::info("Multihoice Payment Params being sent to Vas 4.0: ". print_r($parameters, true));

        try {

            $response = $this->guzzleClient()->request('POST', $this->vasOperations->vasUrl.'/v1/vas/cabletv/subscription', $parameters);
            $responseData = $this->responseToArray($response);
            
            \Log::info("Cable Tv Payment Response: " . print_r($responseData, true));
            
            if($responseData['responseCode'] == "00"){
                return response()->json([ 'data' => $responseData ], 200);
            } else {
                return response()->json([ 'data' => $responseData ], 400);
            }

        } catch (\Exception | RequestException $e) {
            $requeryResponse =  $this->vasOperations->requeryTransaction($clientReference);
           if($requeryResponse['responseCode'] == "00"){
                \Log::info($params['service']." Successful Rerquery". print_r($requeryResponse, true));
                return response()->json([ 'data' => $requeryResponse ], 200);
           }else{
                if ($e->hasResponse()) {
                    $exceptionDetails = [
                        'message' => $e->getMessage(),
                        'file' => basename($e->getFile()),
                        'line' => $e->getLine(),
                        'type' => class_basename($e),
                        'body' => $e->getResponse()->getBody()->getContents()
                    ];

                    \Log::info("Multichoice Payment Exception ". print_r($exceptionDetails, true));

                    $data = json_decode($exceptionDetails['body'], true);

                    return response()->json([ 'data' => $data ], 400);
                }
                \Log::info("Multichoice Payment Exception". $e->getMessage());
                $data = [ 'message' =>  'An Exception occurred, Please contact Itex' ];
                return response()->json([ 'data' => $data ], 400);
            }
        }
    }


    public function validateIUC(Request $request){
        if(isset($request->view)){
            $params = $request->all();
        } else {
            $params = json_decode($request->getContent(), true);
        }

        $validator =  Validator::make($request->all(), RequestRules::getRule('MULTICHOICE_LOOKUP'));
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

        try {
            if($params['cable_unit'] == "STARTIMES"){
                $userDetails = $this-> getUserDetails($request); // Get User Details
                $jsonParams = [
                    'service' =>  'startimes',
                    'type' => "default",
                    "channel" => "WEB",
                    'smartCardCode' => $params['card'],
                ];
                
                $headers = $this->vasOperations->getVasHeaders($jsonParams);
                $parameters = [
                    'json' => $jsonParams,
                    'headers' =>$headers
                ];

                \Log::info("Startimes Validation Params being sent to Vas 4.0: ". print_r($parameters, true));

                 // Create an Instance of Http Client Resource
                 $response = $this->guzzleClient()->request('POST', $this->vasOperations->vasUrl.'/v1/vas/cabletv/validation', $parameters);
                $responseData = $this->responseToArray($response);
                
                \Log::info("Startimes Validation Response: " . print_r($responseData, true));

                if($responseData['responseCode'] == "00"){
                    // session()->put('productCode', $responseData['data']['productCode']);
                    if(isset($request->view)){
                        $responseData['data']['unit'] = $params['cable_unit'];
                        $status = true;
                        $data = $this->htmlStarTimesPlans($responseData['data']);
                        return $this->returnHtmlOutput($status,$data);
                    } else {
                        $msg = $responseData['message'];
                        $data = $responseData;
                        return $this->jsonoutput($msg, $data, HttpStatusCodes::OK);
                    }

                } else {
                    if(isset($request->view)){
                        $status = false;
                        $data = $responseData['message'];
                        return $this->returnOutput($status,$data);
                    } else {
                        $data = $responseData['message'];
                        return $this->validationError($data, HttpStatusCodes::BAD_REQUEST);
                    }
                }
            } else {

                $jsonParams = [
                    'type' =>  $params['cable_unit'],
                    'service' => "multichoice",
                    'channel' => 'WEB',
                    'account' => $params['card']
                ];

                $headers = $this->vasOperations->getVasHeaders($jsonParams);
                $parameters = [
                    'json' => $jsonParams,
                    'headers' =>$headers
                ];

                \Log::info("Multihoice Validation Params being sent to Vas 4.0: ". print_r($parameters, true));

                // Create a new Instance of Http Client Resource
                $responseValidation = $this->guzzleClient()->request('POST', $this->vasOperations->vasUrl.'/v1/vas/cabletv/validation', $parameters);
                $responseData = $this->responseToArray($responseValidation);

                \Log::info("Multichoice Startimes Validation Response: " . print_r($responseData, true));

                if($responseData['responseCode'] == "00"){
                    session()->put('productCode', $responseData['data']['productCode']);
                    //dd($responseData);
                    $responseData['data']['account_status'] = $responseData['data']['account_status'] ?? "Valid";
                    $responseData['data']['iuc'] = $params['card'];
                    //dd($responseData);
                    if(isset($request->view)){
                        $status = true;
                        $data = $this->htmlDataPlans($responseData['data']);
                        return $this->returnHtmlOutput($status,$data);
                    } else {
                        $msg = "IUC Validated Successfully";
                        $data = $responseData['data'];
                        return $this->jsonoutput($msg, $data, HttpStatusCodes::OK);
                    }

                } elseif($responseData['error'] == true) {
                    if(isset($request->view)){
                        $status = false;
                        $data = $responseData['message'];
                        return $this->returnOutput($status,$data);
                    } else {
                        $data = $responseData['message'];
                        return $this->validationError($data, HttpStatusCodes::BAD_REQUEST);
                    }
                }
            }


        } catch (\Exception $e) {
            // \Log::info("Multichoice Payment Exception: " . $e->getResponse()->getBody()->getContents());
            \Log::info("Multichoice Payment Exception: " . $e->getMessage());            
            if(isset($request->view)){
                $status = false;
                $data = "An exception occured while processing request. Please try again";
                return $this->returnOutput($status,$data);
            } else {
                $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                return $errorMsg;
            }
            
        }

    }



    private function htmlStarTimesPlans($responseData){
        $bouquet = $responseData['bouquet'];
        $name = $responseData['name']." (".$bouquet.")";
        $dataPlans = $responseData['bouquets'];
        $unit = $responseData['unit'];
        $balance = (float) $responseData['balance'];
        $smartCardCode = $responseData['smartCardCode'];
        $productCode = $responseData['productCode'];

        $form = "";
        if($balance <= 60){
            $form .= '<div>
            <span style="float:right; font-size: 10px; font-weight: bold;"><i class="fa fa-circle text-danger"></i> Balance -  &#8358;'.$balance.'</span></div>';
        } else {
            $form .= '<div>
            <span style="float:right; font-size: 10px; font-weight: bold;"><i class="fa fa-circle text-success"></i> Balance -  &#8358;'.$balance.'</span></div>';
        }

        $form .= '<div class="paymentDetails" > </div> <form method="post" accept-charset="utf-8" id="cableTvPayBill" data-parsley-validate>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon no-padding no-bg no-bd">
                            <i class="ion-person fstylec"></i>
                            </div>
                            <input class="form-control" type="text" value="'.$name.'" readonly name="">
                            <input type="hidden" name="smartCardCode" value="'.$smartCardCode.'" />
                            <input type="hidden" name="productCode" value="'.$productCode.'" />
                            <input type="hidden" name="unit" value="'.$unit.'" />
                        </div>
                    </div>';
        $form .= '<div class="row">';

        foreach($dataPlans as $data){
            $bouquet = $data['name'];
            $string = "";
            $form .= '           
                <div class="card col-12" style="padding-top: 20px; padding-bottom: 20px;">
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="selectedBouquet" id="exampleRadios1" value="'.$bouquet.'">
                        <label class="form-check-label" style="display: inline !important; padding-right: 20px;" for="exampleRadios1">
                        '.$bouquet.'
                        </label>
                        </div>

                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="cycle" id="exampleRadios1" value="daily">
                        <label class="form-check-label" style="display: inline !important; padding-right: 20px;" for="exampleRadios1">
                            Daily N'. $data['cycles']['daily'].'
                        </label>

                        <input class="form-check-input" type="radio" name="cycle" id="exampleRadios1" value="weekly">
                        <label class="form-check-label" style="display: inline !important; padding-right: 20px;" for="exampleRadios1">
                            Weekly N'. $data['cycles']['weekly']. '
                        </label>

                        <input class="form-check-input" type="radio" name="cycle" id="exampleRadios1" value="monthly">
                        <label class="form-check-label" style="display: inline !important; padding-right: 20px;" for="exampleRadios1">
                            Monthly N'. $data['cycles']['monthly']. '
                        </label>
                        </div>
                    </div>';
            };

        $form .= '</div>';
        $form .= '<div class="card col-12" style="padding-top: 20px; padding-bottom: 20px;">
            <div class="form-group block medium" >Enter Phone Number:</div> <div class="block"><input type="number" name="phone" required placeholder=""/></div> </div>';
        $form .= '<div class="card col-12" style="padding-top: 20px; padding-bottom: 20px;">
            <div class="form-group block medium" >Enter Wallet PIN:</div> <div class="block"><input type="password" name="pin" required class="pincode-input5" pattern="[0-9]{4}" maxlength="4" 
            placeholder=" Your 4-Digit Pin"/></div> </div>';
        $form .= '<input type="hidden" name="view" value="'. rand(). ' " />
                    <div id="alert" >
                    </div>
                    <div class="form-group">
                    <button type="submit" class="cableTvPayBillBtn btn-customb btn-block arrow-btn waves-effect waves-classic">
                        <span class="billProceedBtnOne">PAY FOR SELECTED PLAN</span>
                        <span class="arrow"></span>
                    </button>
                </div>
            </form> ';

        return $form;
    }

    private function htmlDataPlans($responseData){
        $unit = $responseData['unit'];
        $fullname = $responseData['name']." (".$unit.")";
        $dataPlans = $responseData['bouquets'];
        $account_status = $responseData['account_status'];
        $iuc = $responseData['iuc'];

        $form = "";
        if($account_status == "SUSPENDED"){
            $form .= '<div class="p-20"><span style="font-size: 11px; font-weight: bold;"> <a href="/tran/paybills?page=billoptiontv"><i class="fa fa-arrow-left mr-10"></i> Choose Another Service</a></span><span style="float:right; font-size: 10px; font-weight: bold;"><i class="fa fa-circle text-danger"></i> '.$account_status.'</span></div>';
        } else {
            $form .= '<div class="p-20"><span style="font-size: 11px; font-weight: bold;"> <a href="/tran/paybills?page=billoptiontv"><i class="fa fa-arrow-left mr-10"></i> Choose Another Service</a></span><span style="float:right; font-size: 10px; font-weight: bold;"><i class="fa fa-circle text-success"></i> '.$account_status.'</span></div>';
        }

        $form .= '<div class="paymentDetails" > </div><form method="post" accept-charset="utf-8" id="cableTvPayBill" data-parsley-validate>
                    <div class="form-group no-margin">
                            <i class="ion-person fstylec"></i>
                            <input class="form-control" type="text" value="'.$fullname.'" readonly name="">
                            <input type="hidden" name="iuc" value="'.$iuc.'" />
                            <input type="hidden" name="unit" value="'.$unit.'" />
                    </div>';
        $form .= '<div class="form-group no-margin p-20 m-height"><table class="table re-tbl-bordered table-striped table-hover" style="text-align: left; font-size: 11px;">';

        foreach($dataPlans as $data){
            $product_code = $data['product_code'] ?? $data['code'];
            $form .= '<tr>
                            <td>
                            <div class="radio"><label><input type="radio" name="product_code" id="Radios2" value="'.$product_code.'" required><span>'.$data['name'].'   <span class="right">&#8358;'.$data['amount'].'</span></span></label></div>
                            </td>
                        </tr>';
            };

        $form .= '</table></div>';
        $form .= '<div class="text-center no-margin p-10"><p class="medium block">Enter Wallet PIN:</p></div> <div class="text-center no-margin"> <input type="password" name="pin" required class="pincode-input5" pattern="[0-9]{4}" maxlength="4" placeholder=" Your 4-Digit Pin"/></div>';
        $form .= '<input type="hidden" name="view" value="'. rand(). ' " />
                    <div id="alert" >
                    </div>
                    <div class="form-group p-20">
                    <button type="submit" class="cableTvPayBillBtn btn-customb btn-block arrow-btn waves-effect waves-classic">
                        <span class="billProceedBtnOne">PAY FOR SELECTED PLAN</span>
                        <span class="arrow"></span>
                    </button>
                </div>
            </form> ';

        return $form;
    }


}
