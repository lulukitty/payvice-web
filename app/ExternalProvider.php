<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class ExternalProvider extends Model
{
    //

	public static function simplyEncrypt($string, $action = 'e'){

		$secret_key = env("PROVIDER_SECRET_KEY", "Th1s1Sth3secreIentrance4");
		$secret_iv = env("PROVIDER_SECRET_IV", "1fy0uAr3n0TLnvitedD0nTShow");

		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

		if( $action == 'e' ) {
			$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
		}
		else if( $action == 'd' ){
			$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
		}

		return $output;

	}

	public static function generateToken($details){

		$response['status'] = 0;

		$secret = env("PROVIDER_JWT_SECRET", "Th1sp0W3rfullW3bbT0k3NisS3cuRe");
		$secret .= md5($secret);

		$tokenHeader['alg'] = "HS256";
		$tokenHeader['typ'] = "JWT";

		$tokenPayload['ema'] = $details['email'];
		$tokenPayload['tid'] = $details['tid'];
		$tokenPayload['acc'] = $details['acc'];
		$tokenPayload['key'] = $details['key'];
		$tokenPayload['enc'] = $details['enc'];
		$tokenPayload['name'] = $details['name'];
		$tokenPayload['ide'] = rand(1, 1000);
		$tokenPayload['dev'] = rand(1, 1000);
		$tokenPayload['iss'] = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->toDateTimeString();
		$tokenPayload['exp'] = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->addMinutes(120)->toDateTimeString();
		$tokenPayload['age'] = "Android Device";

		$tHeader = base64url_encode(json_encode($tokenHeader));
		$tPayload = base64url_encode(static::simplyEncrypt(json_encode($tokenPayload)), 'e');

		$signThis = $tHeader . $tPayload;

		$tSignature = hash_hmac('sha256', $signThis, $secret);

		$jwt = $tHeader . "." . $tPayload . "." . $tSignature;

		$response['status'] = 1;
		$response['jwt'] = $jwt;
		$response['expiry'] = $tokenPayload['exp'];

		return $response;

	}


	public static function validateToken($details){

		$response['status'] = 0;
		$response['message'] = "Invalid Authorization Token";

		$secret = env("PROVIDER_JWT_SECRET", "Th1sp0W3rfullW3bbT0k3NisS3cuRe");
		$secret .= md5($secret);

		$theJWT = explode(".", $details['jwt']);

		$signThis = $theJWT[0] . $theJWT[1];

		$theMatch = hash_hmac('sha256', $signThis, $secret);

		if($theMatch === $theJWT[2]){

			$tokenHeader = json_decode(base64url_decode($theJWT[0]));
			$tokenPayload = json_decode(static::simplyEncrypt(base64url_decode($theJWT[1]), 'd'));

            $response['message'] = "Token Expired"; //. Carbon::createFromFormat('Y-m-d H:i:s', $tokenPayload->iss)->diffInMinutes(now(), false) . "-" . now()->diffInMinutes(Carbon::createFromFormat('Y-m-d H:i:s', $tokenPayload->exp), false);

            if((Carbon::createFromFormat('Y-m-d H:i:s', $tokenPayload->iss)->diffInMinutes(Carbon::now(), false) < 121) && (Carbon::now()->diffInMinutes(Carbon::createFromFormat('Y-m-d H:i:s', $tokenPayload->exp), false) >= 0)){

            	$response['status'] = 1;
            	$response['message'] = "Valid Authorization Token";
            	$response['payload'] = $tokenPayload;

            }

            

        }

        return $response;

    }


}
