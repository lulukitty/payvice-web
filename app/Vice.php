<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vice extends Model
{
	protected $table = 'vices';

	protected $fillable = ['token', 'vice_id', 'status'];
}
