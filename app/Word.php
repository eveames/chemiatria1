<?php

namespace chemiatria;

use Illuminate\Database\Eloquent\Model;
use chemiatria\Altword;
use chemiatria\Topic;

class Word extends Model
{
    //
    protected $fillable = ['word', 'prompts'];
    public function altwords(){
    	return $this->hasMany('chemiatria\Altword');
  	}

  	public function topics()
  	{
  		return $this->belongsToMany('chemiatria\Topic');
  	}

}
