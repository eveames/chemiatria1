<?php

namespace chemiatria;

use Illuminate\Database\Eloquent\Model;
use chemiatria\Topic;
use chemiatria\Skill;
use chemiatria\Word;
use chemiatria\Action;
use chemiatria\Fact;

class State extends Model
{
    //
    protected $guarded = [];
    public function topics()
  	{
  		return $this->belongsToMany('chemiatria\Topic');
  	}
    public function studyable()
    {
      return $this->morphTo();
    }
    public function user()
    {
      return $this->belongsTo('chemiatria\User');
    }
    public function actions()
    {
      return $this->hasMany('chemiatria\Action');
    }
    public function detail()
    {
      //$detail = $state->stats();
      $detail = $this->studyable->detail();
      $detail['stage'] = $this->stage;
      $detail['id'] = $this->id;

      //dd($studyable);
      return $detail;
    }
    public function data()
    {
      $detail = $this->studyable->data();
      $detail['stage'] = $this->stage;
      $detail['id'] = $this->id;
      $detail['priority'] = $this->priority;
      $detail['accs'] = $this->accuracies;
      $detail['rts'] = $this->rts;
      $detail['lastStudied'] = $this->lastStudied;
      $detail['topic_ids'] = $this->topics()->pluck('topic_id')->toArray();
      return $detail;
    }
    public static function storeWord(User $user, Topic $topic, Word $word)
    {
        // Validate the request...

        $state = new State;
        $state->setupNew($state);
        //dd('back in storeWord');
        //$state->studyable_type = "word";
        $state->studyable()->associate($word);
        $state->user()->associate($user);
        $state->priority = $topic->id;
        //dd('about to save', $state);
        $state->save();
        $state->topics()->attach($topic->id);
        return;

    }
    public static function storeFact(User $user, Topic $topic, Fact $fact)
    {
        // Validate the request...

        $state = new State;
        $state->setupNew($state);
        //dd('back in storeWord');
        //$state->studyable_type = "word";
        $state->studyable()->associate($fact);
        $state->user()->associate($user);
        $state->priority = $topic->id;
        //dd('about to save', $state);
        $state->save();
        $state->topics()->attach($topic->id);
        return;

    }
    public static function storeSkill(User $user, Topic $topic, Skill $skill)
    {
      $state = new State;
      $state->setupNew($state);
      $topic->states()->attach($state->id);
      $state->studyable_type = "Skill";
      $state->studable()->associate($skill);
      $state->user()->associate($user);
      $state->priority = $topic->id;
      dd('about to save', $state);
      $state->save();
    }
    private function setupNew($state)
    {
      $state->accuracies = '';
      $state->rts = '';
      $state->history = '';
      $state->lastStudied = 0;
      $state->stage = 0;
      $state->current = 1;
      //dd('about to save', $state);
      //$state->save();
      return $state;
    }
    private function stats($state)
    {
      //convert stage to a word?

      //calculate recent accuracy
      if($state->accuracies !== '')
      {
        $accs = json_decode($state->accuracies);
        // do some sensible calculation like accuracy of most recent 20 in %

        $rts = json_decode($state->rts);
        //do something smart
        return array('accuracy' => $accs, 'times' => $rts);
      }


    }
}
