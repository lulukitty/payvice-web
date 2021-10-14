<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Helpers\Response;
use App\Helpers\generator;
use App\Helpers\customCode;
use GuzzleHttp\Client as GuzzleHttpClient;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Response, generator;

    protected function returnOutput($status,$data){
        if($status == true){
            $output['status'] = true;
            $output['data'] = '<p class="alert alert-success text-center" style="text-align: center; margin-right: 20%; margin-left: 20%"> <i class="fa fa-check fa-fw"> </i> '.$data.' </p>';
        } else {
            $output['status'] = false;
            $output['data'] = '<p class="alert alert-danger text-center" style="text-align: center; margin-right: 20%; margin-left: 20%"> <i class="fa fa-ban fa-fw"> </i> '.$data.' </p>';
        }
        return json_encode($output);
    }

    protected function returnHtmlOutput($status,$data){
        if($status == true){
            $output['status'] = true;
            $output['data'] = '<p> '.$data.' </p>';
        } else {
            $output['status'] = false;
            $output['data'] = '<p> '.$data.' </p>';
        }
        return json_encode($output);
    }

    protected function returnUnencodedHtmlOutput($status,$data){
        if($status == true){
            $output['status'] = true;
            $output['data'] = '<p> '.$data.' </p>';
        } else {
            $output['status'] = false;
            $output['data'] = '<p> '.$data.' </p>';
        }
        return $output['data'];
    }

    protected function displayValidationError($errorResponse){
        if(is_object($errorResponse)){
        $errordata = $errorResponse->original;
        $errorMessageArray = $errordata['message'];
            if(is_array($errorMessageArray)){
                $errorResponse = implode(',<br>',$errorMessageArray);
            } else {
                $errorResponse = $errorMessageArray;
            }
        }
        $output['data'] = '<p class="alert alert-danger text-center"style="text-align: center; margin-right: 20%; margin-left: 20%"> <i class="fa fa-times fa-fw"> </i> '.$errorResponse.' </p>';
        $ouput['status'] = "failure";
        return json_encode($output);
    }

    protected function getUserDetails($request){
        $data['username'] = $request->session()->get('curUsr');
		$data['wallet_id'] = $request->session()->get('curAcc');
        $data['email'] = $request->session()->get('curEm');
        $data['password'] = $request->session()->get('usrKeyPass');
        return $data;
    }

    protected function responseToArray($response){
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $response->getBody()->getContents());
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $fileContents = str_replace("'",'"', $fileContents);
        $phpArray = json_decode($fileContents, true);
        return $phpArray;
    }

    protected function responseXmlToArray($response){
        $fileContents = str_replace(array("", "\r", "\t"), '', $response->getBody()->getContents());
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents);
        $json = json_encode($simpleXml);
        $phpArray = json_decode($json, true);
        return $phpArray;
    }

    protected function logRequests($logTitle){
        $logRequest = request()->except(['password', 'pin']);
        \Log::info($logTitle.":  " . print_r($logRequest, true));
        return true;
    }

    protected function jsonToArray($data) {
        $Content = json_decode($data, true);
        return $Content;
    }

    protected function arrayToJson($data) {
        $Content = json_encode($data, true);
        return $Content;
    }

    protected function sessionKey($request){
        $sessionKey = $request->session()->get('sessionKey');
        if(is_null($sessionKey)){
            $sessionKey = $this->generateSessionKey($request);
        } else {
            $sessionKey = $sessionKey;
        }
        return $sessionKey;
    }

    public function guzzleClient(){
        $client = new GuzzleHttpClient;
        return $client;
    }

      /**
     * This method interacts with VAS API and generates a unique session key for consequent requests
     * This only happens once for every users session
     */

    public function generateSessionKey($request){
        $thisUserDetails = $this->getUserDetails($request);
        $sess = $request->session()->get('sessionKey');
        //dd($sess);
            $jsonParams = [
                'wallet' =>  $thisUserDetails['wallet_id'],
                'terminal' =>  null,
                'username' =>  $thisUserDetails['email'],
                'password' =>  $thisUserDetails['password'],
                'channel' =>  'WEB',
                'deviceID' =>  null,
            ];

            try {
                $response = $this->guzzleClient()->request('POST', 'http://197.253.19.76:8019/api/v1/vas/generate-sessionKey', [
                    'json' => $jsonParams
                ]);

                $responseData = $this->responseToArray($response);
                if($responseData['responseCode'] == "00"){
                    $sessionKey = $responseData['data']['sessionKey'];
                    $sessionKey = $request->session()->put('sessionKey', $sessionKey);
                    $data['status'] = true;
                    $data['sessionKey'] = $sessionKey;
                    return $data;
                } else {
                    $dataMsg = $responseData['message'];
                    return $dataMsg;
                }

            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                    return $errorMsg;
                }
            }

    }

}
