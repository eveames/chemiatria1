<?php

namespace chemiatria;

use Illuminate\Database\Eloquent\Model;
use chemiatria\Topic;
use chemiatria\State;

class Fact extends Model
{
    //
    public function topics()
  	{
  		return $this->belongsToMany('chemiatria\Topic');
  	}
    public function states()
    {
      return $this->morphMany('chemiatria\State', 'studyable');
    }
    public function users()
    {
      return $this->hasManyThrough('chemiatria\User', 'chemiatria\State');
    }
    public function data()
    {
      return ['name' =>$this->key, 'type_id' => $this->id, 'type' => 'fact', 'subtype' => $this->group_name];
    }
    public function detail()
    {
      return ['name' =>$this->key . $this->key_name . $this->prop . $this->prop_name, 
      'type_id' => $this->id, 'type' => 'fact', 'subtype' => $this->group_name];
    }
}
