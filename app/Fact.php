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
    public function name()
    {
      $name = '';
      if ($this->group_name == 'acids' || $this->group_name == 'commonCompound' ||
        $this->group_name == 'elementSymbol') $name = $this->key;
      else if ($this->group_name == 'polyatomic ions') $name = $this->prop;
      else if ($this->group_name == 'elementCharge') $name = $this->key . ' charges';
      else if ($this->group_name == 'elementGroup') $name = $this->key . ' group';
      else if ($this->group_name == 'conversion factor') $name = $this->key_name . ' to ' . $this->prop_name;
      else if ($this->group_name == 'numerical constant') $name = $this->prop_name . ' of ' . $this->prop;
      else $name = $this->key . $this->key_name . $this->prop . $this->prop_name;
      return $name;
    }
    public function detail()
    {
      $name = $this->name();
      return ['name' => $name, 'type_id' => $this->id, 'type' => 'fact', 'subtype' => $this->group_name];
    }
}
