<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $table = 'transactions';

	protected $fillable = ['token', 'vice', 'ref', 'status', 'tran_ben', 'tran_amount', 'tran_type', 'ie_token', 'payer_name', 'payer_address'];
}
