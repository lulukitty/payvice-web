<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class HttpRequests
{

    public static function baseURI(){
        $uri = 'http://197.253.19.75:8029/';
        return $uri;
    }

    public static function httpHeaders(){
        $headers = [
            'Authorization' => 'IISYSGROUP c1e750cf89b05b0fc56eecf6fc25cce85e2bb8e0c46d7bfed463f6c6c89d4b8e',
            'sysid' => 'ee2dadd1e684032929a2cea40d1b9a2453435da4f588c1ee88b1e76abb566c31',
            'Content-Type' => 'application/json'
        ];
        return $headers;
    }

    public static function tamsBaseURI(){
        $uri = 'http://197.253.19.78/ctms/eftpos/';
        return $uri;
    }

    public static function vas4SessionKeyUrl(){
        $uri = 'http://197.253.19.76:8018/api/v1/vas/generate-sessionKey';
        return $uri;
    }

    // http://197.253.19.76:8018/api/v1/vas/generate-sessionKey
    


}
