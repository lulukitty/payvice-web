<?php

namespace App\Helpers;

use App\Helpers\customCode;

Trait Response {

    public function exceptionError($msg, $httpCode) {
        return response()->json([
            'status' => false,
            'http_code' => $httpCode,
            'message' => $msg
        ], $httpCode);
    }

    public function error($msg, $httpCode) {
        return response()->json([
            'status' => false,
            'http_code' =>$httpCode,
            'message' => $msg
        ], $httpCode);
    }

    public static function validationError($msg, $httpCode=200) {
        return response()->json([
            'status' => false,
            'http_code' =>$httpCode,
            'message' => $msg
        ], $httpCode);
    }

    public static function success($msg, $httpCode) {
        return response()->json([
            'status' => true,
            'http_code' => $httpCode,
            'message' => $msg
        ], $httpCode);
    }

    public static function jsonoutput($msg, $data, $httpCode) {
        return response()->json([
            'status' => true,
            'http_code' => $httpCode,
            'message' => $msg,
            'data' => $data
        ], $httpCode);
    }

    public function issueUserToken($token, $msg, $httpCode, $data) {
        return response()->json([
            'status' => true,
            'http_code' => $httpCode,
            'message' => $msg,
            'token' => $token,
            'data' => $data
        ], $httpCode);
    }

    public function tokenError($msg, $httpCode) {
        return response()->json([
            'status' => false,
            'http_code' => $httpCode,
            'error' =>  $msg
        ], $httpCode);
    }

}