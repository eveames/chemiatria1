<?php

namespace chemiatria;

use Illuminate\Database\Eloquent\Model;
use chemiatria\State;
use chemiatria\User;

class Action extends Model
{
    //
    protected $guarded = [];
    public function states()
  	{
  		return $this->belongsToMany('chemiatria\State');
  	}
    public function user()
    {
      return $this->belongsTo('chemiatria\User');
    }
}
