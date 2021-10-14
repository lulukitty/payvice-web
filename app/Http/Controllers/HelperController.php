<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Http\Request;
use App\Helpers\HttpStatusCodes;
use App\Http\Controllers\HttpRequests;
use GuzzleHttp\Exception\RequestException;
use function GuzzleHttp\json_encode;


class HelperController extends Controller
{
    // protected $client;

    // public function __construct(){
    //     $this->client = new GuzzleHttpClient;
    // }
    public function uniqueClientReference($request){
        $sessionKey = $this->sessionKey($request);
        $timestamp = date('Y-m-d H:i:s.u');
        $rrn = $this->generateSecureRef(13).time();
        $randomString = $this->generateSecureRef(12);

        $data = array(
            'sessionKey' => $sessionKey,
            'timestamp' =>  $timestamp,
            'rrn' =>  $rrn,
            'randomString' => $randomString
        );

        $dataObject = json_encode($data, JSON_FORCE_OBJECT);
        $encoded = base64_encode($dataObject);
        return $encoded;
    }

    public function requeryTransaction($userDetails, $ref){
        $requeryParams = [
            "wallet" => $userDetails['wallet_id'],
            "username" => $userDetails['email'],
            "password" => $userDetails['password'],
            "reference" => $ref,
            "channel" => "WEB"
        ];

        $requeryResponse = $this->guzzleClient()->request('POST', HttpRequests::baseURI().'/api/v1/account/requery', [
            'json' => $requeryParams,
            'headers' => HttpRequests::httpHeaders()
        ]);
        $requeryResponseData = $this->responseToArray($requeryResponse);
        //dd($requeryResponseData);
        if($requeryResponseData['error'] == false){
            $status = $requeryResponseData['transaction']['status'];
            if($status == "failed" or $status == "declined"){
                return false;
            } else {
                return true;
            }
        } else {
            return null;
        }
        
    }


}
