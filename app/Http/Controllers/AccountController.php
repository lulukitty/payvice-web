<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Account;

use App\APITransaction;

class AccountController extends Controller
{
    //

    private $apiTransaction;

    public function __construct(APITransaction $apiTransaction){

        $this->apiTransaction = $apiTransaction;

    }

    public function index(){


    	$response['status'] = 0;
    	$response['error'] = true;
    	$response['message'] = "There was an error";
    	$response['date'] = date("Y-m-d H:i:s");

    	$validator = \Validator::make(request()->all(), [
    		'username' => 'required|string',
    		'password' => 'required|string',
    	]);

    	if ($validator->fails()){
    		$response['status'] = 2;
    		$response['message'] = "Invalid Request";	
    		$response['error'] = $validator->errors();
    	}
    	else {

           $username = request('username');
           $password = request('password');

           $processLogin = Account::login($username, $password);

    			//dd($processLogin);

           if($processLogin->status === 1){

            $userEmail = $processLogin->userDetails['email'] ?? '';
            $walletId = $processLogin->userDetails['account'] ?? '';
            $name = str_replace("<macros>", "", $processLogin->userDetails['name'] ?? '');

            $processBalance = Account::balance($walletId, $userEmail);

    				//dd($processBalance);

            if($processBalance->status === 1){

             $response['status'] = 1;
             $response['error'] = false;
             $response['message'] = "Request Successful";
             $response['balance'] = $processBalance->balance ?? 0;
             $response['commissionBalance'] = $processBalance->commission ?? 0;
             $response['walletID'] = $walletId;
             $response['name'] = $name;
             $response['email'] = $userEmail;


         } else {

             $response['status'] = 3;
             $response['message'] = $processBalance->message ?? "Unable to complete, please try again";	
             $response['error'] = null;

         }

     } else {

        $response['status'] = 2;
        $response['message'] = $processLogin->message ?? "Please check login details and try again";	
        $response['error'] = null;

    }



}


return response()->json($response);
}

public function dashboard(){
    try{
        $userEmail = session('curEm');
    $walletID = session('curAcc');

    //dd(request()->all());
    $validationRules = [
        'subAgent'=>'nullable|string',
        'startDate'=>'nullable|date|date_format:"Y-m-d',
        'endDate'=>'nullable|date|date_format:"Y-m-d"',
        'product'=>'nullable|string',
        'limit'=>'nullable|integer|min:1|max:100',
        'page'=>'nullable|integer|min:1',
    ];

    $customMessages = [

    ];

    $validator = validator()->make(request()->all(), $validationRules, $customMessages);


    $userBalance = Account::balance($walletID, $userEmail);

    $balance = $userBalance->balance ?? 0;
    $commission = $userBalance->commission ?? 0;

    if ($validator->fails()) {

        $response['status'] = 2;
        $response['message'] = "Invalid Request Parameters";
        $response['errors'] = $validator->errors();
        $historyError = $response['errors'];

    } else {

        $historyError = false;

    }

    $viewWallet = request("subAgent") ?? $walletID;
    $viewProduct = request("product") ?? "ALL";
    $startDate = request("startDate") ?? date('Y-m-d');
    $endDate = request("endDate") ?? date('Y-m-d');
    $limit = request("limit") ?? 5000000;
    $currentPage = request("page") ?? '';

    $transactionHistory = Account::transactionHistory($viewWallet, $viewProduct, $startDate, $endDate, $limit, $currentPage);
    $products = Account::fetchProducts();

    
    if($transactionHistory->status){

        if($transactionHistory->error === true){
            // Return Error Page
        }

        $transactions = $transactionHistory->transactions;

        $transactionSummary = $transactionHistory->transactionSummary;

        $nextPage = false;
        $previousPage = false;

        $pageQueryString = request()->getQueryString();

        $pageQueryString = preg_replace('/([&]?)(page)(=)([0-9]*)/i', "", $pageQueryString);

        $fullPageUrl = url('/dashboard/transaction-history?') . $pageQueryString;

        $pageUrl = $fullPageUrl . (strlen($pageQueryString) > 0 ? '&page=' : 'page=');

        $nextPageUrl = $pageUrl;
        $previousPageUrl = $pageUrl;


        if($transactionHistory->lastPage > $transactionHistory->currentPage) {

            $nextPage = (int) $transactionHistory->currentPage + 1;
            $nextPageUrl .= $nextPage;

        }

        if($transactionHistory->currentPage > 1) {

            $previousPage = (int) $transactionHistory->currentPage - 1;
            $previousPageUrl .= $previousPage;

        } 

    } else {
        \Log::info("Failed to get Transaction History " . print_r($transactionHistory, true));
        return response()->view('errors.500', [], 500);

    }

    $viewData = ['balance' => number_format($balance, 2), 'commission' => number_format($commission, 2), 'transactions' => $transactions, 'errors' => $historyError, 'transactionSummary' => $transactionSummary, 
    'products' => $products, 'currentProduct' => request('product'), 'nextPage' => $nextPage, 'previousPage' => $previousPage, 'nextPageUrl' => $nextPageUrl, 'previousPageUrl' => $previousPageUrl, 'commissionBalance' => number_format($commission, 2)];

    return view('history', $viewData);

    } catch(\Exception $e){

        \Log::info("Transaction History Exception (Account Controller)" . print_r($e->getMessage(), true));

        
    }
    
        

    }


    public function ft_dashboard(){
        try{
            $userEmail = session('curEm');
        $walletID = session('curAcc');
    
        //dd(request()->all());
        $validationRules = [
            'subAgent'=>'nullable|string',
            'startDate'=>'nullable|date|date_format:"Y-m-d',
            'endDate'=>'nullable|date|date_format:"Y-m-d"',
            'product'=>'nullable|string',
            'limit'=>'nullable|integer|min:1|max:100',
            'page'=>'nullable|integer|min:1',
        ];
    
        $customMessages = [
    
        ];
    
        $validator = validator()->make(request()->all(), $validationRules, $customMessages);
    
    
        $userBalance = Account::balance($walletID, $userEmail);
    
        $balance = $userBalance->balance ?? 0;
        $commission = $userBalance->commission ?? 0;
    
        if ($validator->fails()) {
    
            $response['status'] = 2;
            $response['message'] = "Invalid Request Parameters";
            $response['errors'] = $validator->errors();
            $historyError = $response['errors'];
    
        } else {
    
            $historyError = false;
    
        }
    
        $viewWallet = request("subAgent") ?? $walletID;
        $viewProduct = request("product") ?? "ALL";
        $startDate = request("startDate") ?? date('Y-m-d');
        $endDate = request("endDate") ?? date('Y-m-d');
        $limit = request("limit") ?? 5000000;
        $currentPage = request("page") ?? '';
    
        $transactionHistory = Account::ft_transactionHistory($viewWallet, $viewProduct, $startDate, $endDate, $limit, $currentPage);
        
        if($transactionHistory['status'] == 1){
            $historyStatus = $transactionHistory['transactionHistory']->status;
            if($historyStatus !== 200){
                // Return Error Page
            }
            $historyInfo = $transactionHistory['transactionHistory']->data;
    
            $transactions = $historyInfo->transactions;
    
            $transactionSummary = $historyInfo->transactionSummarry;
    
            $nextPage = false;
            $previousPage = false;
    
            $pageQueryString = request()->getQueryString();
    
            $pageQueryString = preg_replace('/([&]?)(page)(=)([0-9]*)/i', "", $pageQueryString);
    
            $fullPageUrl = url('/dashboard/transaction-history?') . $pageQueryString;
    
            $pageUrl = $fullPageUrl . (strlen($pageQueryString) > 0 ? '&page=' : 'page=');
    
            $nextPageUrl = $pageUrl;
            $previousPageUrl = $pageUrl;
    
    
            if($transactionSummary->lastPage > $transactionSummary->currentPage) {
    
                $nextPage = (int) $transactionSummary->currentPage + 1;
                $nextPageUrl .= $nextPage;
    
            }
    
            if($transactionSummary->currentPage > 1) {
    
                $previousPage = (int) $transactionSummary->currentPage - 1;
                $previousPageUrl .= $previousPage;
    
            }
    
            $productsDropDown = "";
    
            $theProducts = (array) $transactionSummary->products;
    
    
            $allProducts = [
                'name' => 'All Products'
            ];
    
            $allProducts = (object) $allProducts;
    
            $theProducts['ALL'] = $allProducts;
    
    
            array_unshift($theProducts, $allProducts);
    
            $theProducts = (object) $theProducts;
    
            foreach($theProducts as $transactionProductKey => $transactionProductValue){
    
                if(strtoupper(request('product')) == $transactionProductKey && strlen(request('product')) > 1){
                    $productsDropDown = '<option value = \'' . $transactionProductKey .'\'>' . $transactionProductValue->name . '</option>' . $productsDropDown;
                } else {
                    $productsDropDown .= '<option value =  \'' . $transactionProductKey .'\'>' . $transactionProductValue->name . '</option>';
                }
    
            }
    
            $walletsDropDown = "";
    
            $theWallets = $historyInfo->subAgents;
    
            $allWallets['name'] = "Sub Agents and You";
            $allWallets['walletID'] = "ALL";
    
            $yourWallet['name'] = "Your Wallet";
            $yourWallet['walletID'] = $walletID;
    
            $allWallets = (object) $allWallets;
            $yourWallet = (object) $yourWallet;
    
            array_unshift($theWallets, $allWallets);   
            array_unshift($theWallets, $yourWallet);   
    
            //dd($theWallets);
    
            foreach($theWallets as $subAgent){
    
                if(strtoupper(request('subAgent')) == $subAgent->walletID && strlen(request('subAgent')) > 1){
                    $walletsDropDown = '<option value = \'' . $subAgent->walletID . '\'>' . $subAgent->walletID . ' - ' . substr($subAgent->name, 0, 25) . '</option>' . $walletsDropDown;
                } else {
                    $walletsDropDown .= '<option value = \'' . $subAgent->walletID .'\'>' . $subAgent->walletID . ' - ' . substr($subAgent->name, 0, 25) . '</option>';
                }
    
            }
    
            //dd($walletsDropDown, $productsDropDown); 
    
        } else {
            \Log::info("Failed to get Transaction History " . print_r($transactionHistory, true));
            return response()->view('errors.500', [], 500);
    
        }
    
        $viewData = ['balance' => number_format($balance, 2), 'commission' => number_format($commission, 2), 'transactions' => $transactions, 'errors' => $historyError, 'historyInfo' => $historyInfo, 'transactionSummary' => $transactionSummary, 'nextPage' => $nextPage, 'previousPage' => $previousPage, 'nextPageUrl' => $nextPageUrl, 'previousPageUrl' => $previousPageUrl, 'walletsDropDown' => $walletsDropDown, 'productsDropDown' => $productsDropDown, 'commissionBalance' => number_format($commission, 2)];
    
        return view('ft-history', $viewData);
    
        } catch(\Exception $e){
    
            \Log::info("Transaction History Exception (Account Controller)" . print_r($e->getMessage(), true));
    
            
        }
        
            
    
        }

public function walletLookup(){

    $response['status'] = 0;
    $response['error'] = true;
    $response['message'] = "There was an error";
    $response['date'] = date("Y-m-d H:i:s");
    $response['error'] = [];

    $validator = \Validator::make(request()->all(), [
        'username' => 'required|string',
        'password' => 'required|string',
        'wallet' => 'required|string',
    ]);

    if ($validator->fails()){
        $response['status'] = 2;
        $response['message'] = "Invalid Request";   
        $response['error'] = $validator->errors();
    }
    else {

        $username = request('username');
        $password = request('password');

        $processLogin = Account::login($username, $password);

            //dd($processLogin);

        if($processLogin->status === 1){

            $walletID = request('wallet');

            $processLookup = Account::walletLookup($walletId);

                //dd($processLookup);

            if($processLookup->status === 1){

                $response['status'] = 1;
                $response['error'] = false;
                $response['message'] = $processLookup->message;
                $response['name'] = $processLookup->name;
                $response['walletID'] = $walletId;

            } else {

                $response['status'] = 3;
                $response['message'] = $processLookup->message ?? "Unable to complete, please try again";  
                $response['error'] = null;

            }

        } else {

            $response['status'] = 2;
            $response['message'] = $processLogin->message ?? "Please check login details and try again";    
            $response['error'] = null;

        }


    }

    return response()->json($response);

}


public function walletTransfer(){

    $theWallet = null;

    $response['status'] = 0;
    $response['error'] = true;
    $response['message'] = "There was an error";
    $response['date'] = date("Y-m-d H:i:s");
    $response['error'] = [];

    $validator = \Validator::make(request()->all(), [
        'username' => 'required|string',
        'password' => 'required|string',
        'pin' => 'required|string',
        'amount' => 'required|string',
        'beneficiary' => 'required|string',
    ]);

    if ($validator->fails()){
        $response['status'] = 2;
        $response['message'] = "Invalid Request";   
        $response['error'] = $validator->errors();
    }
    else {

        $apiTransactionDetails['account'] = request('beneficiary');
        $apiTransactionDetails['amount'] = (int) request('amount');
        $apiTransactionDetails['username'] = request('username');
        $apiTransactionDetails['product'] = "WALLETTRANSFER";
        $apiTransactionDetails['category'] = "WALLET";
        $apiTransactionDetails['name'] = "Wallet Transfer";
        $apiTransactionDetails['description'] = "Internal Wallet Transfer";

        $theReceiver = request('beneficiary') ?? '';
        $theAmount = request('amount') ?? '';
        $theUsername = request('username');

        $apiTransactionDetails['narration'] = "Internal Wallet Transfer of $theAmount from $theUsername to $theReceiver";

        $savedTransaction = $this->apiTransaction->saveTransaction($apiTransactionDetails);

        if($savedTransaction['status'] !== 1){

            if($savedTransaction['status'] === 21){

                $response = $savedTransaction;

            } else {

                $response['status'] = 4;
                $response['message'] = "Unable to initiate transaction";

            }

            return response()->json($response);

        }

        $response['transactionID'] = $savedTransaction['transactionID'];


        $username = request('username');
        $password = request('password');

        $processLogin = Account::login($username, $password, true);

            //dd($processLogin);

        if($processLogin->status === 1){

            $theWallet = $processLogin->wallet ?? null;

            $pin = request("pin");

            $encryptedPassword = $processLogin->encryptedPassword ?? '';
            $walletId = $processLogin->userDetails['account'] ?? '';

            $encryptedPin = Account::getEncryptedPin($pin, $encryptedPassword);

                //dd($encryptedPin);

            $beneficiary = request('beneficiary');
            $amount = (double) request('amount') / 100;

            $processTransfer = Account::walletTransfer($username, $walletId, $beneficiary, $amount, $encryptedPin);

               //dd($processTransfer);

            if($processTransfer->status === 1){

                $response['status'] = 1;
                $response['error'] = false;
                $response['message'] = $processTransfer->message;
                $response['amount'] = $processTransfer->amount;
                $response['beneficiary'] = $processTransfer->beneficiary;
                $response['balance'] = $processTransfer->balance;
                $response['reference'] = $processTransfer->reference;
                $response['beneficiaryReference'] = $processTransfer->beneficiaryReference;

                $updateApiTransactionDetails = [];

                $updateApiTransactionDetails['status'] = "successful";
                $updateApiTransactionDetails['reason'] = "transactionsuccessful";
                $updateApiTransactionDetails['reference'] = $processTransfer->reference;
                $updateApiTransactionDetails['walletId'] = $theWallet ?? null;

                $updateApiTransactionDetails['value'] = $processTransfer->beneficiaryReference;
                $updateApiTransactionDetails['token'] = $processTransfer->reference;
                $updateApiTransactionDetails['message'] =  $response['message'];
                $updateApiTransactionDetails['response'] =  json_encode($response);

                $updatedTransaction = $this->apiTransaction->updateSavedTransaction($savedTransaction['transactionID'], $updateApiTransactionDetails);

                if($updatedTransaction['status'] !== 1){

                    $response['status'] = 5;
                    $response['message'] = "Unable to update transaction";

                    return response()->json($response);

                }


            } else {

                $response['status'] = 3;
                $response['message'] = $processTransfer->message ?? "Unable to complete, please try again";  
                $response['error'] = true;

                $updateApiTransactionDetails = [];

                $updateApiTransactionDetails['walletId'] = $theWallet ?? null;

                $updateApiTransactionDetails['status'] = "failed";
                $updateApiTransactionDetails['reason'] = "transactionfailed";
                $updateApiTransactionDetails['message'] =  $response['message'];
                $updateApiTransactionDetails['response'] =  json_encode($response);

                $updatedTransaction = $this->apiTransaction->updateSavedTransaction($savedTransaction['transactionID'], $updateApiTransactionDetails);

                if($updatedTransaction['status'] !== 1){

                    $response['status'] = 5;
                    $response['message'] = "Unable to update transaction";

                    return response()->json($response);

                }

            }

        } else {

            $theWallet = $processLogin->wallet ?? null;

            $response['status'] = 2;
            $response['message'] = $processLogin->message ?? "Please check login details and try again";    
            $response['error'] = true;

            $updateApiTransactionDetails = [];

            $updateApiTransactionDetails['walletId'] = $theWallet ?? null;

            $updateApiTransactionDetails['status'] = "declined";
            $updateApiTransactionDetails['reason'] = "authenticationfailed";
            $updateApiTransactionDetails['message'] =  $response['message'];
            $updateApiTransactionDetails['response'] =  json_encode($response);

            $updatedTransaction = $this->apiTransaction->updateSavedTransaction($savedTransaction['transactionID'], $updateApiTransactionDetails);

            if($updatedTransaction['status'] !== 1){

                $response['status'] = 5;
                $response['message'] = "Unable to update transaction";

                return response()->json($response);

            }

        }


    }

    return response()->json($response);


}


}
