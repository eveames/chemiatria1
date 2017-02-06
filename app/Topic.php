<?php

namespace chemiatria;

use Illuminate\Database\Eloquent\Model;
use chemiatria\Word;

class Topic extends Model
{
    //
    public function words() 
    {
    	return $this->belongsToMany('chemiatria\Word');
    }
}
