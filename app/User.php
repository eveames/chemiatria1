<?php

namespace chemiatria;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use chemiatria\Topic;
use chemiatria\State;
use chemiatria\Skill;
use chemiatria\Word;
use chemiatria\Action;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     * 'auth_type' takes values student, teacher, admin
     */
    protected $hidden = [
        'password', 'remember_token','auth_type'
    ];

    public function states()
    {
      return $this->hasMany('chemiatria\State');
    }
    public function actions()
    {
      return $this->hasMany('chemiatria\Action');
    }
    public function words()
    {
      return $this->hasManyThrough('chemiatria\Word', 'chemiatria\State');
    }
    public function skills()
    {
      return $this->hasManyThrough('chemiatria\Skill', 'chemiatria\State');
    }
    public function topics()
    {
      return $this->hasManyThrough('chemiatria\Topic', 'chemiatria\State');
    }

}
