<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \Carbon\Carbon;

class APITransaction extends Model
{
    //

	public function saveTransaction($transactionDetails){

		$saveError = false;

		try {

			$saveTransaction = new $this;

            //Prepare these details to be saved

			$vasTransaction = $transactionDetails;

			$vasTransaction['numericalAmount'] = ((double) $transactionDetails['amount'])/100;
			$vasTransaction['higherDenominationAmount'] = ((double) $transactionDetails['amount'])/100;
			$vasTransaction['channel'] = $transactionDetails['channel'] ?? 'WEB';
			$vasTransaction['status'] = $transactionDetails['status'] ?? 'initialized';
			$vasTransaction['created_at'] = Carbon::now();
			$vasTransaction['updated_at'] = Carbon::now();

            //Add Client Reference
			if(request('clientReference') !== null && strlen(trim(request('clientReference'))) > 1){
				$vasTransaction['clientReference'] = trim(request('clientReference'));
			}

			$username = $vasTransaction['username'] ?? null;
			$clientReference = $vasTransaction['clientReference'] ?? null;


			if($username && $clientReference){

				$duplicateSearch = new $this;

				$findDuplicate = $duplicateSearch->where('username', $username)->where('clientReference', $clientReference)->first();

				if($findDuplicate){

					$saveError = true;

					$response['status'] = 21;
					$response['message'] = "Duplicate Transaction";
					$response['description'] = "Duplicate Transaction $clientReference for $username";

					$response['username'] = $username;
					$response['clientReference'] = $clientReference;

					$response['originalTransaction']['amount'] = $findDuplicate->amount ?? 0;
					$response['originalTransaction']['date'] = $findDuplicate->created_at;
					$response['originalTransaction']['response'] = $findDuplicate->response ?? '';
					$response['originalTransaction']['account'] = $findDuplicate->account ?? '';
					$response['originalTransaction']['currencyCode'] = $findDuplicate->currencyISOAlpha ?? null;
					$response['originalTransaction']['status'] = $findDuplicate->status ?? null;
					$response['originalTransaction']['message'] = $findDuplicate->message ?? '';
					$response['originalTransaction']['value'] = $findDuplicate->value ?? '';
					$response['originalTransaction']['token'] = $findDuplicate->token ?? '';
					$response['originalTransaction']['reference'] = $findDuplicate->reference ?? '';
					$response['originalTransaction']['name'] = $findDuplicate->name ?? '';

					\Log::error("Duplicate transaction error: " . print_r($response, true));

					return $response;

				}

			}


			$transactionReference = $saveTransaction->insertGetId(
				$vasTransaction
			);

			if($transactionReference){

				$response['status'] = 1;
				$response['message'] = "Transaction Saved";
				$response['transactionID'] = $transactionReference;

			} else {

				$response['status'] = 2;
				$response['message'] = "Transaction Not Saved";
			}


		} catch (\Exception $e) {

			$exceptionDetails = [
				'message' => $e->getMessage(),
				'file' => basename($e->getFile()),
				'line' => $e->getLine(),
				'type' => class_basename($e)
			];

			\Log::error("An Exception Occured in Saving Transaction: " . print_r($exceptionDetails, true));

			$response['status'] = 5;
			$response['message'] = "An Exception Occured Saving Transaction";
			

		}

		return $response;

	}

	public function updateSavedTransaction($transactionID, $transactionDetails){

		try {

                //$transactionID = $transactionDetails['transactionID'];

			$savedTransaction = static::find($transactionID);


			if($savedTransaction){

                 //Prepare Fields

				$transactionDetails['message'] = substr(($transactionDetails['message'] ?? ''), 0, 150);

				$updateTransaction = $savedTransaction->update($transactionDetails);


				if($updateTransaction){

					$response['status'] = 1;
					$response['message'] = "Transaction Updated";
					$response['transactionID'] = $transactionID;

					return $response;

				}

				$response['status'] = 3;
				$response['message'] = "Transaction Not Updated";

				return $response;

			}

			$response['status'] = 2;
			$response['message'] = "Transaction Not Found";

			return $response;

		} catch (\Exception $e) {

			$exceptionDetails = [
				'message' => $e->getMessage(),
				'file' => basename($e->getFile()),
				'line' => $e->getLine(),
				'type' => class_basename($e)
			];

			\Log::error("An Exception Occured in Updating Saved Transaction: " . print_r($exceptionDetails, true));

			$response['status'] = 5;
			$response['message'] = "An Exception Occured Saving Transaction";

			return $response;

		}



	}

	protected $guarded = ['id'];

}
