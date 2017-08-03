<?php

namespace chemiatria;

use Illuminate\Database\Eloquent\Model;
use chemiatria\Topic;
use chemiatria\State;

class Skill extends Model
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
    public function detail()
    {
      return ["name" => $this->skill, 'description' => $this->description];
    }
    public function data()
    {
      return ['name' =>$this->skill, 'type_id' => $this->id, 'type' => 'skill', 'subtype' => $this->subtype];
    }

}
