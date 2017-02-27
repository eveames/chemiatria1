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

    foreach($topics as $topic){
      //add words
      $words = $topic->words()->get();
      foreach($words as $word){
        //dd($word);
        State::storeWord($user, $topic, $word);
      }
      //add skills
      $skills = $topic->skills();
      foreach($skills as $skill){
        State::storeSkill($user, $topic, $skill);
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
