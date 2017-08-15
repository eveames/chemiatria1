<?php

namespace chemiatria\Helpers;

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Mail;
//use chemiatria\Mail\Report;
//use Illuminate\Support\Facades\Session;
use chemiatria\State;
use chemiatria\Topic;
use chemiatria\User;
use chemiatria\Word;
use chemiatria\Skill;

class SessionPlanHelper
{
  //returns states organized into prev (previous session),
  //unseen, due and other (studied before the last session, and not due for review)
  public function formatProgress(User $user)
  {
    $states = $user->states()->get();
    //dd($states);
    if($states->count()=== 0) return null;
    $notSeen = $user->states()->where('lastStudied',0)->get();
    //dd($notSeen);
    $unseenDetails = self::stateDetailsByTopic($notSeen);
    //dd($unseenDetails);
    $previousSession = $user->states()->where([
      ['current', '=', 1],
      ['lastStudied', '<>', 0],
      ])->get();
    $prevDetails = self::stateDetailsByTopic($previousSession);

    $dueToReview = $user->states()->whereBetween('priority',[1000, time()+3600])->get();
    $dueDetails = self::stateDetailsByTopic($dueToReview);
    $otherStates = $states->diff($previousSession)->diff($notSeen)->diff($dueToReview);
    $otherDetails = self::stateDetailsByTopic($otherStates);
    $data = ['prev' => $prevDetails, 'unseen' => $unseenDetails,
      'due' => $dueDetails, 'other' => $otherDetails];
    //dd($data);
    return $data;
  }

  public function checkDue(User $user)
  {
    $dueToReview = $user->states()->whereBetween('priority',[1000, time()+3600])->get();
    return $dueToReview->count();
  }

  //
  public function organizeNew(User $user)
  {
    $studiedTopics = $user->topics();
    $topics = Topic::all();
    $newTopics = $topics->diff($studiedTopics);
    $topicDetailsArray = [];
    foreach($newTopics as $topic){
      $topicDetail = [
        'id' => $topic->id,
        'name' => $topic->topic,
        'words' => [],
        'skills' => [],
        'selected' => false,
      ];
      $topicDetail['words'] = $topic->words()->pluck('word');
      $topicDetail['skills'] = $topic->skills()->pluck('skill');
      //dd($topicDetail['words']);
      $topicDetailsArray[$topicDetail['id']] = $topicDetail;
    }
    //dd($newTopics);
    return $topicDetailsArray;
  }

  //$topicIDsToAdd is an array of the topic IDs
  public function addStatesByTopic($topicIDsToAdd, User $user)
  {
    $topics = Topic::find($topicIDsToAdd);
    $studyables = $user->states()->with('studyable')->get();
    $oldWords = $studyables->map(function($item) {
      if ($item->studyable_type == "chemiatria\Word") return $item->studyable;
    });
    $oldFacts = $studyables->map(function($item) {
      if ($item->studyable_type == "chemiatria\Fact") return $item->studyable;
    });
    $oldSkills = $studyables->map(function($item) {
      if ($item->studyable_type == "chemiatria\Skill") return $item->studyable;
    });

    $oldWords = $oldWords->filter(function($item) {
      return !is_null($item);
    });
    $oldFacts = $oldFacts->filter(function($item) {
      return !is_null($item);
    });
       $oldSkills = $oldSkills->filter(function($item) {
      return !is_null($item);
    });

    //dd($studyables);
    //need to find a way to check if each word/fact/skill is already a state for this user

    foreach($topics as $topic){
      //add words
      $words = $topic->words()->get();
      if ($oldWords->isNotEmpty()) {$wordsToAdd = $words->diff($oldWords);}
      else $wordsToAdd = $words;
      foreach($wordsToAdd as $word){
        //dd($word);

        State::storeWord($user, $topic, $word);
      }
      //add skills
      $skills = $topic->skills();
      //dd($oldSkills);
      if ($oldSkills->isNotEmpty()) {$skillsToAdd = $skills->diff($oldSkills);}
      else $skillsToAdd = $skills;
      foreach($skillsToAdd as $skill){
        State::storeSkill($user, $topic, $skill);
      }
      //add facts
      $facts = $topic->facts()->get();
      if ($oldFacts->isNotEmpty()) {$factsToAdd = $facts->diff($oldFacts);}
      else $factsToAdd = $facts;
      foreach($factsToAdd as $fact){
        //dd($word);
        State::storeFact($user, $topic, $fact);
      }
    }
  }
  private static function stateDetailsByTopic($statesArray)
  {
    $detailsByTopic = [];
    foreach($statesArray as $state)
    {

      $topics = $state->topics()->get();
      //dd($topics);
      $detail = $state->detail();
      foreach($topics as $topic)
      {
        $id = $topic->id;
        $detailsByTopic[$id]['string'] = isset($detailsByTopic[$id]['string']) ?
          $detailsByTopic[$id]['string'] . ', ' . $detail['name'] : $detail['name'];
        $detailsByTopic[$id][] = $detail;
        $detailsByTopic[$id]['name'] = $topic->topic;
      }
    }
    //dd('detailsByTopic', $detailsByTopic);
    return $detailsByTopic;
  }
}
