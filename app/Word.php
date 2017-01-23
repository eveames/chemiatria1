<?php

namespace chemiatria;

use Illuminate\Database\Eloquent\Model;
use chemiatria\Altword;

class Word extends Model
{
    //
    protected $fillable = ['word', 'prompts'];
    public function alternates(){
    	return $this->hasMany('chemiatria\Altword');
  	}
}
