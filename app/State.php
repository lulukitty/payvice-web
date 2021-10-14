<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /*
    * Every terminal belongs to a merchant
    */
    public function parentOwner(){
    	return $this->belongsTo('App\Merchant', 'id', 'merchant_id');
    }


    /*
    * Terminal has many transactions
    */
    public function terminalTransactions(){
    	return $this->hasMany('App\Journal', 'term_id', 'tid');
    }
}
