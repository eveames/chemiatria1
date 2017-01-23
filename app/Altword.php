<?php

namespace chemiatria;

use Illuminate\Database\Eloquent\Model;
use chemiatria\Word;

class Altword extends Model
{
    //
    protected $fillable = ['alt','correct', 'message', 'MCprompt'];

  	public function word() {
    	return $this->belongsTo('chemiatria\Word');
	}
}
