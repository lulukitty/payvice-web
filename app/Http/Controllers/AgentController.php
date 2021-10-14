<?php

namespace App\Http\Controllers;

use App\Utils\RequestRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use \GuzzleHttp;


class AgentController extends Controller
{   
    private $wallet;
    private $username;
    private $password;

    public function __construct()
    {   
        $this->adminWallet = "27613263";
        $this->adminUsername = "itextest@hotmail.com";
        $this->adminPassword = "48398378";

        $this->client = new GuzzleHttp\Client([
            'verify' => false,
        ]);
    } 

    public function getPage(){
                return view('onboarding/index');
    }
    
    public function validateAgentPhone(Request $request){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string',
            'mobile' => 'required|string',
            'countryCode' => 'required|string'
        ]);

        if ($validator->fails()) {
            $errorResponse = $validator->messages()->all();
            \Log::info($errorResponse);
            return response()->json(['status' => 400, 'message' => $errorResponse ]);
        }

        
        $apiUrl = "https://payvice.itexapp.com:5009/v1/auth/validateuseremailandphonenumber";
        $header = [
            'Content-Type' => 'application/json',
        ];

        $data = $request->all();

        if($data['countryCode'] === '234' && $data['mobile'][0] === '0'){
            return response()->json(['status' => 400, 'message' => 'Invalid Mobile Number, Start with the first non zero number']);
        }

        $params = [
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'mobile' => ''.$data['countryCode'].' '.$data['mobile'].'',
            "channel" => "web-agent-onboarding"
        ];

        \Log::info("Valildation Parameters" . print_r($params, true));
    
        $parameters = [
            'json' => $params,
            'headers' => $header,
        ];
    
        try {
            $clientResponse = $this->client->request('POST', $apiUrl, $parameters);
            $code = $clientResponse->getStatusCode();
            \Log::info("Response from payvice validate user email and phone" . print_r($clientResponse, true));
            if ($code == 200 || $code == 201) {
                $jsonResponse = $clientResponse->getBody()->getContents();
                $response = json_decode($jsonResponse);
                \Log::info("Response from payvice validate user email and phone" . print_r($response, true));

                session(['activation-mobile' => ''.$data['countryCode'].' '.$data['mobile'].'' ]);

                return response()->json(['status' => 200, 'message' => 'Activation Code Successfully sent']);
            }
    
        } catch (\Exception | RequestException $e) {    
            if (method_exists($e, 'hasResponse') && $e->hasResponse()) {
                $response['status']  = $e->getResponse()->getStatusCode();
                $res = json_decode($e->getResponse()->getBody()->getContents());
                \Log::info("Direct Response" . print_r($res, true));
                $response['message'] = $res->message;
                $response['responseType'] = "exception";
            } else {
                $response['status'] = 2;
                $response['process'] = "A request exception might have occured";
                $response['message'] = "There was an exception";
            }
            \Log::info("Email and Phone validation error" . print_r($response, true));
            return response()->json(['status' => $response['status'], 'message' => $response['message'] ]);
        }


    }

    // public function verifyActivationCode(){
    //     $mobile = session('activation-mobile');
    //     if(empty($mobile)){
    //         return $this->getPage();
    //     }else{
    //         return view('onboarding/confirm')->with('mobile', $mobile);
    //     }
    // }

    public function confirmActivationCode(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'mobile' => 'required|string'
        ]);

        if ($validator->fails()) {
            $errorResponse = $validator->messages()->all();
            \Log::info($errorResponse);
            return response()->json(['status' => 400, 'message' => $errorResponse ]);
        }

        $apiUrl = "https://payvice.itexapp.com:5009/v1/activate/activateUser";
        $header = [
            'Content-Type' => 'application/json',
        ];

        $data = $request->all();

        $params = [
            'activationCode' => $data['code'],
            'mobile' => $data['mobile'],
            "channel" => "web-agent-onboarding"
        ];

    
        $parameters = [
            'json' => $params,
            'headers' => $header,
        ];

        \Log::info("Activation Params" . print_r($parameters, true));
    
        try {
            $clientResponse = $this->client->request('POST', $apiUrl, $parameters);
            $code = $clientResponse->getStatusCode();
            \Log::info("Activation Success Response" . print_r($clientResponse, true));
            if ($code == 200) {
                $jsonResponse = $clientResponse->getBody()->getContents();
                $response = json_decode($jsonResponse);
                \Log::info("Response from payvice validate user email and phone" . print_r($response, true));

                session(['userCode' => $response->userCode ]);

                return response()->json(['status' => 200, 'message' => 'Activation Code Confirmed']);
            }
    
        } catch (\Exception | RequestException $e) {    
            if (method_exists($e, 'hasResponse') && $e->hasResponse()) {
                $response['status']  = $e->getResponse()->getStatusCode();
                $res = json_decode($e->getResponse()->getBody()->getContents());
                \Log::info("Direct Response" . print_r($res, true));
                $response['message'] = $res->message;
                $response['responseType'] = "exception";
            } else {
                $response['status'] = 2;
                $response['process'] = "A request exception might have occured";
                $response['message'] = "There was an exception";
            }
            \Log::info("Activation Error Response" . print_r($response, true));
            return response()->json(['status' => $response['status'], 'message' => $response['message'] ]);
        }

    }

    public function merchantDetails(){
        // $userCode = '0000';
        $userCode = session('userCode');
        if(empty($userCode)){
            return $this->getPage();
        }

        try {
            // Get Trade Partners List
            $url = 'https://payvice.itexapp.com:5009/v1/agents/gettpcodes';
            $res = $this->client->request('GET', $url);
            if($res->getStatusCode() == 200){
                $response = $res->getBody()->getContents();
                \Log::info("Trande Partners" . print_r($response, true));
                $responseArray = json_decode($response, true);
                // dd($responseArray['data']);
                $data['TP'] = $responseArray['data'];
                $data['userCode'] = $userCode;
                return view('onboarding/details', $data);
            }
        } catch (RequestException | BaseException | ConnectException $e) {
            if ($e->hasResponse()) {
                $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                return $this->displayValidationError($errorMsg);
            }
        }
    }

    public function saveBioData(Request $request){
        $validator = Validator::make($request->all(), [
            'userCode' => "required|string",
            'password' => "required|string|confirmed",
            'password_confirmation' => "required|string",
            'pin' => "required|string|confirmed",
            'pin_confirmation' => "required|string",
            'profession' => "required|string",
            'office_address' => "required|string",
            'office_state' => "required|string",
            'office_lga' => "required|string",
            'next_of_kin_fullname' => 'required|string',
            'next_of_kin_phone' => "required|string",
            'next_of_kin_email' => "required|string",
            'business_name' => "required|string",
            'position' => "required|string",
            'outlet' => "required|string",
            'trade_partners' => "required|string",
            'date_of_birth' => "required|string",
            'residential_address' => 'required|string',
            'guarantors_first_name' => "required|string",
            'guarantors_last_name' => "required|string",
            'guarantors_profession' => "required|string",
            'guarantors_office' => "required|string",
            'guarantors_residence' => "required|string",
            'guarantors_phone' => "required|string",
            'gt_phone_code' => 'required|string',
            'nok_phone_code' => 'required|string',
            'guarantors_email' => "required|string",
            'guarantors_relationship' => "required|string",
            'bank_account' => "required|string",
            'bank_code' => "required|string",
            'bvn' => "required|string",
            'ward' => 'nullable|string',
            'gender' => 'required|string'
        ]);

        if ($validator->fails()) {
            $errorResponse = $validator->messages()->all();
            \Log::info($errorResponse);
            // $errorResponse = json_encode($errorResponse);
            return response()->json(['status' => 400, 'message' => $errorResponse ]);
        }

        $apiUrl = "https://payvice.itexapp.com:5009/v1/agents/agentbioupdate";
        $header = [
            'Content-Type' => 'application/json',
        ];

        $data = $request->all();

        \Log::info("All request" . print_r($data, true));

        $date = date_create($data['date_of_birth']);
        $dob = date_format($date,"d-M-Y");

        $nok_phone = $data['nok_phone_code'].$data['next_of_kin_phone'];
        $gt_phone = $data['gt_phone_code'].$data['guarantors_phone'];

        $params = [
            'userCode' => $data['userCode'],
            'password' => $data['password'],
            'pin' => $data['pin'],
            'profession' => $data['profession'],
            'office_address' => $data['office_address'],
            'office_state' => $data['office_state'],
            'office_lga' => $data['office_lga'],
            'nokfullname' => $data['next_of_kin_fullname'],
            'nokphone' => $nok_phone,
            'nokemail' => $data['next_of_kin_email'],
            'business_name' => $data['business_name'],
            'position' => $data['position'],
            'outlet' => $data['outlet'],
            'trade_partners' => $data['trade_partners'],
            'date_of_birth' => $dob,
            'residential_address' => $data['residential_address'],
            "channel" => "web-agent-onboarding",
            'gender' => $data['gender'],
            'office_ward' => $data['ward'],

            'guarantor' => [
                "firstname" => $data['guarantors_first_name'],
                "lastname" => $data['guarantors_last_name'],
                "profession" => $data['guarantors_profession'],
                "office_address" => $data['guarantors_office'],
                "residential_address" => $data['guarantors_residence'],
                "mobile" => $gt_phone,
                "email" => $data['guarantors_email'],
                "relationship" => $data['guarantors_relationship']
            ],

            "bankInfo" => [
                "bank_code" => $data['bank_code'],
                "account_number" => $data['bank_account'],
                "bvn" => $data['bvn'],
            ]
        ];

    
        $parameters = [
            'json' => $params,
            'headers' => $header,
        ];

        \Log::info("Biodata Params" . print_r($parameters, true));
    
        try {
            $clientResponse = $this->client->request('POST', $apiUrl, $parameters);
            $code = $clientResponse->getStatusCode();
            \Log::info("Save Biodata Success Response" . print_r($clientResponse, true));
            if ($code == 200) {
                $jsonResponse = $clientResponse->getBody()->getContents();
                $response = json_decode($jsonResponse);
                \Log::info("Success Response from saving biodata" . print_r($response, true));

                session(['activationToken' => $response->data->token ]);

                return response()->json(['status' => 200, 'message' => 'Biodata saved']);
            }
    
        } catch (\Exception | RequestException $e) { 
            if (method_exists($e, 'hasResponse') && $e->hasResponse()) {
                $response['status']  = $e->getResponse()->getStatusCode();
                $res = json_decode($e->getResponse()->getBody()->getContents());
                \Log::info("Direct Response" . print_r($res, true));
                $response['message'] = $res->message;
                $response['responseType'] = "exception";
            } else {
                $response['status'] = 2;
                $response['process'] = "A request exception might have occured";
                $response['message'] = "There was an exception";
            }
            \Log::info("Activation Error Response" . print_r($response, true));
            return response()->json(['status' => $response['status'], 'message' => $response['message'] ]);
        }
    }

    public function uploadsPage(){
        $data['token'] = session('activationToken');
        
        if(empty($data['token'])){
            return $this->getPage();
        }

        return view('onboarding/uploads', $data);
    }

    public function completed(){
         //final step, forget all sessions
         session()->forget(['activationToken', 'userCode', 'activation-mobile']);

         return view('onboarding/completed');
    }
   
    public function regAgent(Request $request){
        $this->logRequests("Params Logging for Agent Onbaording");
        $params = $request->all();
        $validator =  Validator::make($request->all(), RequestRules::getRule('AGENT_ONBOARDING'));
        if($validator->fails()) {
            $errorResponse = $this->validationError($validator->getMessageBag()->all());
            \Log::info($errorResponse);
            return $this->displayValidationError($errorResponse);
        }

        // Verify Bank Account
        $jsonParams = [
            "wallet" => $this->adminWallet,
            "username" => $this->adminUsername,
            "password" => $this->adminPassword,
            "beneficiary" => $params['bank_account'],
            "vendorBankCode" => $params['vendorBankCode'],
            "type" => "default",
            "amount" => 100,
            "channel" => "WEB",
        ];

        try{

            \Log::info("Performing Bank Account Validation");
            $response = $this->guzzleClient()->request('POST', HttpRequests::baseURI().'/vas/vice-banking/transfer/lookup', [
                'json' => $jsonParams,
                'headers' => HttpRequests::httpHeaders(),
                'timeout' => 10, // Response timeout
                'connect_timeout' => 10, // Connection timeout
            ]);
        
            $responseData = $this->responseToArray($response);
            \Log::debug("Validation: ".print_r($responseData, true));

            if($responseData['error'] == true){
                $errorResponse = "Onboarding Failed: Invalid Bank Account Number - ($params[bank_account]) or Bank Name!";
                return $this->displayValidationError($errorResponse);
            } elseif($responseData['status'] > 1){
                $errorResponse = $responseData['message'];
                return $this->displayValidationError($errorResponse);
            }
        } catch (RequestException | ConnectException $e) {
            if ($e->hasResponse()) {
                $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                \Log::info("Tams Reg: ". $errorMsg);
                return $this->displayValidationError($errorMsg);
            }
        }
        
        $regKeys = $this->getUserKeys($params);
        if($regKeys['status'] == true){
            $params['clr'] = $regKeys['clr'];
            $params['userTID'] = $regKeys['userTID'];
            $params['verCode'] = $regKeys['verCode'];
            $regBoolean = $this->regAgentOnTams($params);
            if($regBoolean == false){
                $errorResponse = "Failed to Onboard Agent. Process Terminated";
                return $this->displayValidationError($errorResponse);
            } else {
                // Continue Onboarding
                $status = true;
                $data['message'] = "Agent Onboarding Complete";
                \Log::info($data['message']);
                return $this->returnOutput($status, $data['message']);
            }
            
        } else {
            \Log::debug("Initial Reg: ".print_r($regKeys, true));
            return $this->displayValidationError($regKeys['message']);
        }

    }

    protected function getUserKeys(array $params){
        $termid = '203301ZA';
		$email = $params['email'];
        $username = $params['name'];
        $phone = $params['phone'];
        $hash = hash('sha512', utf8_encode($termid.$email.$username), false);
        
        $regUser = "?action=TAMS_REG&termid=".$termid."&userid=".$phone."&username=".$username."&email=".$email."&device_id=0123456789&key=".$hash;
        \Log::debug($regUser);
        try{
            $res = $this->guzzleClient()->post(HttpRequests::tamsBaseURI().'/devinterface/transactionadvice.php'.$regUser);
            if ($res->getStatusCode() == 200) {
                $phpArray = $this->responseXmlToArray($res);
                \Log::debug("Validation: ".print_r($phpArray, true));
                if(isset($phpArray['error']['errcode'])){
                    $errorMsg['message'] = $phpArray['error']['errmsg'];
                    $errorMsg['status'] = false;
                    return $errorMsg;
                } else {
                    if(isset($phpArray['tran'])){
                        if ($phpArray['tran']['result'] == 1){
                            $errorMsg['message'] = $phpArray['tran']['message'];
                            $errorMsg['status'] = false;
                            return $errorMsg;
                        }else{
                            $clrKey = "";
                            $splitTID = str_split($phpArray['tran']['macros_tid']);
                            $key = explode('|', $phpArray['tran']['key']);
                            foreach ($splitTID as $tidChar) {
                                if (!is_numeric($tidChar))
                                    $tidChar = 7;
        
                                $clrKey .= substr($key[1], $tidChar, 1);
                            }
                            $keyData['status'] = true;
                            $keyData['clr'] = $clrKey;
                            $keyData['userTID'] = $phpArray['tran']['macros_tid']; // Wallet Id
                            $keyData['verCode'] = $phpArray['tran']['PAYVICEKEY']; // Verification Code

                            \Log::info("Tams Reg: ". print_r($keyData, true));
                            return $keyData;
                        }
                    }
                    
                }
                
            }
        } catch (RequestException | ConnectException $e) {
            if ($e->hasResponse()) {
                $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                \Log::info("Tams Reg: ". print_r($errorMsg, true));
                return $this->displayValidationError($errorMsg);
            }
        }
		
    }

    protected function regAgentOnTams(array $params){
        $clrKey = hex2bin($params['clr']);
		$termId = $params['userTID']; // Wallet Id
		$userEmail = $params['email'];
		$userPin = substr($params['phone'], -4); // Last four digits of Agent's mobile number
		$userPassword = $params['phone'];
		$referralCode = "";
        $verCode = $params['verCode'];
        // Extra Params
        $address = $params['address'];
        $profession = $params['profession'];
        $business_name = $params['business_name'];
        $position = $params['position'];
        $outlet = $params['outlet'];
        $office_address = $params['office_address'];
        $tp_code = $params['tp_code'];
        $bank_account = $params['bank_account'];

        // End Extra Params
		$passHash = hash('SHA256', $clrKey.$userPassword);
		$hexPass = hex2bin($passHash);
		$hashPin = hash('SHA256', $hexPass.$userPin);

		$completion = "action=TAMS_PIN_UPDATE&termid=".$termId;
		$completion .= "&userid=".$params['phone']."&password=1234&newpassword=".$passHash;
		$completion .= "&vercode=".$verCode."&pin=1234&newpin=".$hashPin;
        $completion .= "&referalcode=".$tp_code;
        $completion .= "&address=".$address."&profession=".$profession."&business_name=".$business_name."&position=".$position."&outlet=".$outlet."&office_address=".$office_address."&tp_code=".$tp_code."&bank_account=".$bank_account;

        \Log::debug($completion);
        
		$res = $this->guzzleClient()->post(HttpRequests::tamsBaseURI().'/devinterface/transactionadvice.php?'.$completion);
        try{
            if ($res->getStatusCode() == 200) {
                $phpArray = $this->responseXmlToArray($res);
                \Log::info("Tams PIN Update: ". print_r($phpArray, true));
                if(isset($phpArray['error']['errcode'])){
                    $errorMsg = $phpArray['errmsg'];
                    return $this->displayValidationError($errorMsg);
                }
                if ($phpArray['tran']['result'] == 0) {
                    return true;
                }else{
                    return false;
                }
            }
        } catch (RequestException | BaseException | ConnectException $e) {
            if ($e->hasResponse()) {
                $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
                \Log::info("Tams PIN Update: ". print_r($errorMsg, true));
                return $this->displayValidationError($errorMsg);
            }
        }
		
    }

 

          // // Validate Trade Partner's Code
        // $res = $this->guzzleClient()->post(HttpRequests::tamsBaseURI().'/devinterface/transactionadvice.php?action=TAMS_LOGIN&termid='.$params['tp_code'].'&userid=ernest.uduje@iisysgroup.com&control=INIT');
        // try{
        //     if ($res->getStatusCode() == 200) {
        //         $phpArray = $this->responseXmlToArray($res);
        //         if (array_key_exists('tran', $phpArray)) {
        //             if ($phpArray['tran']['result'] != "0") {
        //                 $errorResponse = "Onboarding Failed: Invalid Trade Partner Referral Code!";
        //                 return $this->displayValidationError($errorResponse);
        //             }
        //         }else{
        //             if (array_key_exists('errcode', $phpArray)) {
        //                 $errorResponse = "Onboarding Failed: Invalid Trade Partner Referral Code!";
        //                 return $this->displayValidationError($errorResponse);
        //             }
        //         }
        //     }
        // } catch (RequestException | BaseException | ConnectException $e) {
        //     if ($e->hasResponse()) {
        //         $errorMsg = $this->jsonToArray($e->getResponse()->getBody()->getContents());
        //         return $this->displayValidationError($errorMsg);
        //     }
        // }



}