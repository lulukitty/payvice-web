<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Account;

class CommissionController extends Controller
{
    //

    public function index(){

    	$userEmail = session('curEm');
    	$walletID = session('curAcc');

    	$userBalance = Account::balance($walletID, $userEmail);

    	$balance = $userBalance->balance ?? 0;
    	$commission = $userBalance->commission ?? 0;

    	return view('transfer-commission', ['balance' => $balance, 'commission' => $commission, 'commissionBalance' => $commission]);

    }

    public function transfer(){

    	$response['status'] = 0;
    	$response['message'] = "Unable To Transfer Commission";



    	$allSent = request()->all();

    	$plainPin = request("pin");
    	$amount = request("amount") * 100;
    	$userEmail = session('curEm');
    	$walletID = session('curAcc');

    	$encryptedPin = Account::getEncryptedPin($plainPin);

    	//return $encryptedPin;


    	try{

    		$response['status'] = 0;
    		$response['message'] = "Unable To Transfer Commission";

    		$client = new \GuzzleHttp\Client();
    		$res = $client->get("http://197.253.19.75/ctms/eftpos/devinterface/transactionadvice.php?action=TAMS_WEBAPI&control=ComTrans&userid=$userEmail&pin=$encryptedPin&amount=$amount&termid=$walletID");

    		if ($res->getStatusCode() == 200) {

    			$theirResponse = json_decode($res->getBody()->getContents(), true);

    			if(($theirResponse['status'] ?? null) == 0  && ($theirResponse['result'] ?? null) == 0){

    				$response['status'] = 1;
    				$response['message'] = $theirResponse['message'] ?? "Commission Transfer Successful";
    				$response['newBalance'] = $theirResponse['balance'] ?? 0;
    				$response['newCommission'] = $theirResponse['commission'] ?? 0;


    			} else {

    				$response['status'] = 3;
    				$response['message'] = $theirResponse['message'] ?? "Commission Transfer Failed";
    				$response['newBalance'] = $theirResponse['balance'] ?? 0;
    				$response['newCommission'] = $theirResponse['commission'] ?? 0;

    			}


    		}


    	}catch(\Exception $e){

    		$response['status'] = 2;
    		$response['message'] = "An error occured";
    		$response['process'] = $e;

    	}

    	return response()->json($response);

    }
}
