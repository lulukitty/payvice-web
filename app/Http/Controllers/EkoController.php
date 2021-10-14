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

class EkoController extends Controller
{
    protected $helper;
    protected $client;
    public $vasOperations;

    public function __construct()
    {
        $this->helper = new HelperController;
        $this->vasOperations = new VasFourOperations;
        $this->client = new \GuzzleHttp\Client([ 'verify' => false ]);
    }

    /***
     * Eko Electric Distribution Company 
     * This method validates meter number 
     */

    public function meterLookup(Request $request){
        
        if(isset($request->view)){
            $params = $request->all();
        } else {
            $params = json_decode($request->getContent(), true);
        }

        $validator =  Validator::make($request->all(), RequestRules::getRule('EKO_ELECTRIC_METER_LOOKUP'));
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

        \Log::info("Ekedc validation Params". print_r($params, true));

        $jsonParams = [
            "meterNo" => $params['meter'],
            "accountType" => $params['service'],
            "service" => "ekedc",
            "amount" => $params['amount'],
            "channel" => "WEB"
        ];

        $headers = $this->vasOperations->getVasHeaders($jsonParams);
        $parameters = [
            'json' => $jsonParams,
            'headers' => $headers
        ];

        \Log::info("Eko Validation Payment Params being sent to Vas 4.0: ". print_r($parameters, true));

        try {
            // Create a new Instance of Http Client Resource
            $responseValidation = $this->client->request('POST', $this->vasOperations->vasUrl.'/v1/vas/electricity/validation', $parameters);
            $responseValidationData = $this->responseToArray($responseValidation);
            \Log::info("Eko Validation Direct Response ". print_r($responseValidationData, true));
          
            if($responseValidationData['responseCode'] == "00"){
                if(isset($request->view)){
                    $status = true;
                    $data = $this->mailTemplate('ekedc_payment',$responseValidationData['data']);
                    return $this->returnHtmlOutput($status,$data);
                } else {
                    $msg = $responseValidationData['message'];
                    $data = $responseValidationData['data'];
                    return $this->jsonoutput($msg, $data, HttpStatusCodes::OK);
                }

            } else{
                if(isset($request->view)){
                    $status = false;
                    $data = $responseValidationData['data'];
                    return $this->returnOutput($status,$data);
                } else {
                    $data = $responseData['data'];
                    return $this->validationError($data, HttpStatusCodes::NOT_FOUND);
                }
            }
            
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                \Log::info("Eko Validation Exception ". print_r($errorMsg, true));
                return $errorMsg;
            }
        } catch (ConnectException $e) {
            if ($e->hasResponse()) {
                $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                \Log::info("Eko Validation Exception ". print_r($errorMsg, true));
                return $errorMsg;
            }
        }

    }


    private function mailTemplate($template,$data)
    {
        $contents = view('renders.'.$template, $data)->render();
        return $contents;
    }

}