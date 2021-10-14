<?php
/*
*  @author Michel Kalavanda
*  IISYSGROUP, 2018
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Journal;
use App\State;
use App\User;
use App\Merchant;
use App\Vice;
use Validation;

class IisysgroupController extends Controller
{
	public function newTranJournal(Request $apiCall){

		$headers =  $apiCall->header();

		if (empty($headers['authorization'][0])) {
			return response()->json([
				'status' => 0, 
				'message' => 'Missing request header', 
				'date' => date("d/m/Y H:i:s", time())
				]);
		}else if($headers['authorization'][0] != "IISYS ".env('TMS_APP_KEY')){
			return response()->json([
				'status' => 0, 
				'message' => 'Request is missing authorization credentials', 
				'date' => date("d/m/Y H:i:s", time())
				]);
		}else{
			if($headers['iisysgroup'][0] == hash('SHA256', env('TMS_APP_ID'))){
				$body = json_decode($apiCall->getContent(), true);
				if (count($body) < 2 || count($body['state']) != 16 || count($body['journals']) < 18) {
					return response()->json([
						'status' => 0, 
						'message' => 'Incomplete notification data', 
						'date' => date("d/m/Y H:i:s", time())
						]);
				}else{

					if (count(Merchant::where('mht_tid', $body['journals']['term_id'])->first()) < 1) {
						$createMht = [
						'mht_tid' => $body['journals']['term_id']
						];

						$mht_id = Merchant::createNewMerchantDetails($createMht);

						if ( $mht_id == true) {
							$body['state']['merchant_id'] = $mht_id->id;
							if (State::getTerminalState($body['journals']['term_id']) > 0) {
								if (State::updateTerminalState($body['state']) == true) {
									Journal::crtNewJournal($body['journals']);

									return response()->json([
										'status' => 1, 
										'message' => 'Notification sent successfully', 
										'date' => date("d/m/Y H:i:s", time())
										]);
								}
								
							}else{
								
								if (State::crtNewTerminalState($body['state']) == true) {
									Journal::crtNewJournal($body['journals']);
									return response()->json([
										'status' => 1, 
										'message' => 'Notification sent successfully', 
										'date' => date("d/m/Y H:i:s", time())
										]);
								}
								
							}
							
							
						}
					}else{
						/*MERCHANT ALREADY CREATED*/
						$getMerchant = Merchant::where('mht_tid', $body['journals']['term_id'])->first();
						$body['state']['merchant_id'] = $getMerchant->id;
						if (State::getTerminalState($body['journals']['term_id']) > 0) {

							if (State::updateTerminalState($body['state']) == true) {
								Journal::crtNewJournal($body['journals']);


								return response()->json([
									'status' => 1, 
									'message' => 'Notification sent successfully', 
									'date' => date("d/m/Y H:i:s", time())
									]);
							}
							
						}else{
							if (State::crtNewTerminalState($body['state']) == true) {
								Journal::crtNewJournal($body['journals']);

								return response()->json([
									'status' => 1, 
									'message' => 'Notification sent successfully', 
									'date' => date("d/m/Y H:i:s", time())
									]);
							}else{
								return State::crtNewTerminalState($body['state']);
							}
							
						}
					}
				}
			}else{
				return response()->json([
					'status' => 0, 
					'message' => 'Request is missing authorization header', 
					'date' => date("d/m/Y H:i:s", time())
					]);
			}
		} 

		
	}
}
