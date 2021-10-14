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

class MobileDataController extends Controller
{
    protected $helper;
    protected $client;
    public $vasOperations;

    public function __construct()
    {
        $this->helper = new HelperController;
        $this->vasOperations = new VasFourOperations;
    }

    public function paySubscription(Request $request){
        if(isset($request->view)){
            $params = $request->all();
        } else {
            $params = json_decode($request->getContent(), true);
        }

        $rowNumber = $params['rowNumber'];
        $params['service'] = $params['service'.$rowNumber];
        $params['description'] = $params['description'.$rowNumber];
        $params['amount'] = $params['amount'.$rowNumber];
        $params['code'] = $params['code'.$rowNumber];

        $sessionKey = $this->sessionKey($request);
        $clientReference = $this->helper->uniqueClientReference($request);
        $userDetails = $this-> getUserDetails($request);

        $userPin = $params['pin'];
        $encryptedPin = Account::getEncryptedPin($userPin);
        
        $service = strtolower($params['service']);

        if($service == 'etisalatdata'){
            $service = '9mobiledata';
        }

        $jsonParams = [
            'clientReference' => $clientReference,
            'pin' => $encryptedPin,
            "phone" => $params['phone'],
            "service" => $service,
            "paymentMethod" => "cash",
            "code" => $params['code'],
            "channel" => "WEB",
            'productCode' => session('productCode')
        ];

        $headers = $this->vasOperations->getVasHeaders($jsonParams);

        $parameters = [
            'json' => $jsonParams,
            'headers' => $headers
        ];

        \Log::info('Data Purchase Parameters'. print_r($parameters, true));

        try {

            $response = $this->guzzleClient()->request('POST', $this->vasOperations->vasUrl.'/v1/vas/data/subscribe', $parameters);
            $responseData = $this->responseToArray($response);
            unset($jsonParams['pin']);
            \Log::info("Mobile Data Payment Request: ". print_r($jsonParams, true));
            \Log::info("Mobile Data Payment Response: ". print_r($responseData, true));
            //dd($jsonParams,$responseData);
            //dd($responseData);
            if($responseData['responseCode'] == "00"){
                if(isset($request->view)){
                    $status = true;
                    $msg = $responseData['message'];
                    $data = $msg;
                    return $this->returnOutput($status,$data);
                } else {
                    $msg = $responseData['message'];
                    $data = $responseData;
                    return $this->jsonoutput($msg, $data, HttpStatusCodes::OK);
                }

            } else {
                if(isset($request->view)){
                    $status = false;
                    $msg = $responseData['message'];
                    $data = $msg;
                    return $this->returnOutput($status,$data);
                }
            }

        } catch (\Exception | RequestException $e) {
            $requeryResponse =  $this->vasOperations->requeryTransaction($clientReference);
            if($requeryResponse['responseCode'] == "00"){
                 \Log::info($params['service']." Successful Rerquery". print_r($requeryResponse, true));
                 return response()->json([ 'data' => $requeryResponse ], 200);
            }else{
                 if ($e->hasResponse()) {
                    $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                    \Log::info("Mobile Data Exception: ". print_r($errorMsg, true));
                    $status = false;
                    $data = "An Exception Occured. Please contact ITEX.";
                    return $this->returnOutput($status,$data);
                 }
                 $errorMsg = $e->getMessage();
                \Log::info("Mobile Data Exception: ".$errorMsg);
                $status = false;
                $data = "An Exception Occured. Please contact ITEX.";
                return $this->returnOutput($status,$data);
             }
            
        }

    }

    public function mobileDataLookup(Request $request){
        $validator =  Validator::make($request->all(), RequestRules::getRule('MOBILE_DATA'));
        if($validator->fails()) {
            if(isset($params['view'])){
                $errorResponse = $this->validationError($validator->getMessageBag()->all());
                return $this->displayValidationError($errorResponse);
            } else {
                return $this->validationError($validator->getMessageBag()->all(), HttpStatusCodes::BAD_REQUEST);
            }
        }

        $service = strtolower($request->get('service'));

        if($service == 'etisalatdata'){
            $service = '9mobiledata';
        }

        try{
            $jsonParams = [
                'service' => $service,
                'channel' => 'WEB'
            ];

            $headers = $this->vasOperations->getVasHeaders($jsonParams);

            $parameters = [
                'json' => $jsonParams,
                'headers' => $headers
            ];

            \Log::info('Data lookup Parameters'. print_r($parameters, true));

            // Create an Instance of Http Client Resource
            $response = $this->guzzleClient()->request('POST', $this->vasOperations->vasUrl.'/v1/vas/data/lookup', $parameters);
            $responseData = $this->responseToArray($response);
            \Log::info("Mobile Data Request: ". print_r($jsonParams, true));
            \Log::info("Mobile Data Response: ". print_r($responseData, true));
            if($responseData['responseCode'] =='00'){
                session()->put('productCode', $responseData['data']['productCode']);
                if(isset($request->view)){
                    $status = true;
                    $data = $this->htmlMobileDataPlans($responseData['data']);
                    return $this->returnUnencodedHtmlOutput($status,$data);
                } else {
                    $msg = "Data Plans Lookup Successful";
                    $data = $responseData;
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
            } catch (\Exception $e) {
                $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                \Log::info("Mobile Data Exception: ". print_r($errorMsg, true));
                $status = false;
                $data = "An Exception Occured. Please contact ITEX.";
                return $this->returnOutput($status,$data);
                
            }

    }


    private function htmlMobileDataPlans($responseData){
        $dataPlans = $responseData['data'];
       $form = "";
        $form .= '<div class="form-group m-height"><table class="table re-tbl-bordered table-striped table-hover" style="text-align: left; font-size: 11px; width: 100%;">';
        $i = 0;
        foreach($dataPlans as $data){
            $code = $data['code'];
            $description = $data['description'];
            $amount = $data['amount'];
            $service = $data['type'];

            $form .= '<tr>
                            <td align="center"><input type="radio" name="rowNumber" value="'.$i.'" required></td><td>'.$data['description'].'</td><td>&#8358;'.$data['amount'].'</td>
                            <input type="hidden" name="code'.$i.'" value="'.$data['code'].'" />
                            <input type="hidden" name="description'.$i.'" value="'.$data['description'].'" />
                            <input type="hidden" name="amount'.$i.'" value="'.$data['amount'].'" />
                            <input type="hidden" name="service'.$i.'" value="'.$data['type'].'" />
                        </tr>
                    </div>
                    ';
                    $i++;
            };

        $form .= '</table></div>';
        $form .= ' <div class="form-group">
                        <i class="ion-android-call fstylec"></i>
                        <input placeholder="ENTER PHONE NUMBER" class="form-control" type="text" required="required" min="11" name="phone">
                </div>';
        $form .= '<input type="hidden" name="view" value="'. rand(). ' " />';

        return $form;
    }
}
