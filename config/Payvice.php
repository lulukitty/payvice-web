<?php
namespace Payvice\API\Services;

class Payvice{
	//Function to calculate time different for notification
	public static function timeAgo($timestamp){
		$timestamp      = (int) $timestamp;
		$current_time   = time();
		$diff           = $current_time - $timestamp;
		
		//intervals in seconds
		$intervals      = array (
			'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
			);
		
		if ($diff >= 60 && $diff < $intervals['hour'])
		{
			$diff = floor($diff/$intervals['minute']);
			return $diff == 1 ? $diff : $diff;
		}
	}


	public static function tokenExpiration($time){

		$cur_time = time();
		$diff = abs($cur_time - strtotime($time));

		if($diff >= 180){
			return true;
		}else{
			return false;
		}
	}


	public static function banksSortCode($bankName){
		switch (strtoupper($bankName)) {
			case 'GTB':
			case 'GTBANK':
			case 'GT BANK':

			return '058152052';
			break;

			case 'ZENITH':
			case 'ZENITH BANK':

			return '057150013';
			break;

			case 'WEMA':
			case 'WEMA BANK':
			return '035150103';
			break;

			case 'UNITY':
			case 'UNITY BANK':
			return '215082334';
			break;

			case 'UNION':
			case 'UNION BANK':
			return '032156825';
			break;

			case 'UBA':
			case 'UBA BANK':
			return '033154282';
			break;

			case 'STERLING':
			case 'STERLING BANK':
			return '232150029';
			break;

			case 'STANDARD CHARTERED':
			case 'STANDARD CHARTERED BANK':
			return '068150057';
			break;

			case 'STANBIC IBTC':
			case 'STANBIC IBTC BANK':
			case 'STANBIC':
			return '221159522';
			break;

			case 'SKYE':
			case 'SKYE BANK':
			return '076151006';
			break;

			case 'NIB':
			case 'NIB BANK':
			return '023150005';
			break;

			case 'MAIN STREET':
			case 'MAIN STREET BANK':
			return '014150030';
			break;

			case 'KEYSTONE':
			case 'KEYSTONE BANK':
			return '082150017';
			break;

			case 'JAIZ':
			case 'JAIZ BANK':
			return '301080020';
			break;

			case 'HERITAGE':
			case 'HERITAGE BANK':
			return '030159992';
			break;

			case 'FIRST BANK':
			case 'FBN BANK':
			case 'FIRST':
			return '011152303';
			break;

			case 'FIDELITY':
			case 'FIDELITY BANK':
			return '070150003';
			break;

			case 'FCMB':
			case 'FCMB BANK':
			return '214150018';
			break;

			case 'ETB':
			case 'ETB BANK':
			return '040150101';
			break;

			case 'ENTERPRISE':
			case 'ENTERPRISE BANK':
			return '084150015';
			break;

			case 'ECOBANK':
			case 'ECOBANK BANK':
			return '050150311';
			break;

			case 'DIAMOND':
			case 'DIAMOND BANK':
			return '063150162';
			break;

			case 'CITI':
			case 'CITI BANK':
			return '023150005';
			break;

			case 'ACCESS':
			case 'ACCESS BANK':
			return '044150149';
			break;

			default:
			return NULL;
			break;

		}
	}


	public static function getAgentTransactions(Request $req){

		//Log::info('')
	}


}

