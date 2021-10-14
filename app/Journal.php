<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    /*
    * Every transaction belongs to a terminal
    */
    public function parentTerminal(){
    	return $this->belongsTo('App\State', 'term_id', 'tid');
    }

    
}
