<?php

namespace chemiatria;

use Illuminate\Database\Eloquent\Model;
use chemiatria\Altword;
use chemiatria\Topic;
use chemiatria\State;

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
      $def = json_decode($this->prompts)[0];
      return ['name' => $this->word, 'description' => $def];
    }
    public function data()
    {
      return ['name' =>$this->word, 'type_id' => $this->id, 'type' => 'word'];
    }

}
