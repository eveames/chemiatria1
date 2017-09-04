<?php

namespace chemiatria;

use Illuminate\Database\Eloquent\Model;
use chemiatria\Word;
use chemiatria\Skill;
use chemiatria\State;
use chemiatria\Fact;

class Topic extends Model
{
    //
    public function words()
    {
    	return $this->belongsToMany('chemiatria\Word');
    }
    public function wordsDetailOnly()
    {
      return $this->belongsToMany('chemiatria\Word')->select(array('word'));
    }
    public function skills()
    {
      return $this->belongsToMany('chemiatria\Skill');
    }
    public function states()
    {
      return $this->belongsToMany('chemiatria\State');
    }
    public function users()
    {
      return $this->hasManyThrough('chemiatria\User','chemiatria\State');
    }
    public function facts()
    {
      return $this->belongsToMany('chemiatria\Fact');
    }
}
