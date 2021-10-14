<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
	/*
	* Merchant has many transactions in journals table
	* "Journals" relate to "Merchant" through "State" using merchant_id and tid
	*/
	public function merchantTran(){
		return $this->hasManyThrough('App\Journal', 'App\State', 'merchant_id', 'term_id', 'id')->paginate(100);
	}


	/*
	* Merchant might have many tid
	*/

	public function merchantTerminals(){
		return $this->hasMany('App\State', 'merchant_id', 'id');
	}

	
}
