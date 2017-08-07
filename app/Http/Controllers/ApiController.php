<?php

namespace chemiatria\Http\Controllers;

use Illuminate\Http\Request;
use chemiatria\Word;
use chemiatria\Topic;
use chemiatria\Skill;
use chemiatria\State;
use chemiatria\Altword;
use chemiatria\Fact;
use Illuminate\Support\Facades\Auth;
use chemiatria\Helpers\SessionPlanHelper;
use chemiatria\Action;

class ApiController extends Controller
{
    //
    //controls API used by angular
    public function getWordsByTopic($topic_id) {
    	//returns json object:  {{word: word, prompts: [], alternates: []}, {}, etc}
      $topic = Topic::find($topic_id);
    	$words = $topic->words()->with('altwords')->get();
    	return $words;
    }

    public function getUser() {
    	//returns name and id
      $user = Auth::user();
    	return ['name' => $user->name, 'id' => $user->id];
    }

    public function getWords() {
    	//returns json object:  {{word: word, prompts: [], alternates: []}, {}, etc}
    	try {
            $words = Word::with('altwords')->get();
            return $words;
        }
        catch (Exception $e) {
            $errorMessage = 'Caught exception: ' . $e->getMessage();

            return $errorMessage;
        }
    }

    public function getFacts() {
    	//returns json object all props on fact
    	try {
            $facts = Fact::all();
            return $facts;
        }
        catch (Exception $e) {
            $errorMessage = 'Caught exception: ' . $e->getMessage();

            return $errorMessage;
        }
    }

    //controls API used by angular
    public function getFactsByTopic($topic_id) {
    	//returns json object:  {{word: word, prompts: [], alternates: []}, {}, etc}
      $topic = Topic::find($topic_id);
    	$facts = $topic->facts()->get();
    	return $facts;
    }

    public function getTopics() {
    	//returns json object list all available topics
    	//maybe someday sorts them by course, student progress?
    	$course_id = Auth::user()->course_id;
        Debugbar::info($course_id);
        $course = Course::find($course_id);
        Debugbar::info($course);
        $typesList = $course->questions;
        Debugbar::info($typesList);
    	return $typesList;
    }

    public function getStates() {
    	//returns full list of states for all items in study array, by user
    	$user = Auth::user();
      //$states =
    	$states = $user->states->map(function($item)
        {
          //dd($item->data());
          return $item->data();
        });
      //dd($states);
    	return $states;
    }

    public function getActiveStates() {
    	//returns full list of states for all items in study array, by user
    	$user = Auth::user();
      //$states =
    	$states = $user->states->where('current', 1)->map(function($item)
        {
          //dd($item->data());
          return $item->data();
        });
      //dd($states);
    	return $states;
    }

    public function updateAllStates(Request $request) {
    	//updates states table
        try {
            //Debugbar::info($request);
            $j = count($request);
            //Debugbar::info('length of array'.$j);
            $i = 0;
            while (isset($request[$i]['priority'])) {


                if (isset($request[$i]['states_id'])) {
                    //Debugbar::info($request[$i]);
                    $id = $request[$i]['states_id'];
                    $state = Auth::user()->states()->find($id);
                    $state->lastStudied = $request[$i]['lastStudied'];
                    $state->accuracyArray = json_encode($request[$i]['accuracyArray']);
                    $state->rtArray = json_encode($request[$i]['rtArray']);
                    $state->stage = $request[$i]['stage'];
                    $state->priority = $request[$i]['priority'];
                    //Debugbar::info('state w/ id '. $state);
                    $state->save();
                }

                else {
                    $state = new State();
                    $state->type_id = $request[$i]['type_id'];
                    if (isset($request[$i]['word_id'])) $state->word_id = $request[$i]['word_id'];
                    if (isset($request[$i]['qID'])) $state->qID = $request[$i]['qID'];
                    $state->lastStudied = $request[$i]['lastStudied'];
                    $state->priority = $request[$i]['priority'];
                    $state->stage = $request[$i]['stage'];
                    //Debugbar::info('state w/o id '.$state);
                    $state->accuracyArray = json_encode($request[$i]['accuracyArray']);
                    $state->rtArray = json_encode($request[$i]['rtArray']);
                    $state->subtype = json_encode($request[$i]['subtype']);
                    Auth::user()->states()->save($state);
                }
                ++$i;
            }
            return "Data saved successfully";
        }
        catch (Exception $e) {
            $errorMessage = 'Caught exception: ' . $e->getMessage();

            return $errorMessage;
        }
    }

    public function updateState(Request $request, $id) {
        //updates states table
        //$update = $request->all();
        $state = Auth::user()->states()->find($id);
        $state->lastStudied = $request->lastStudied;
        $state->accuracies = json_encode($request->accs);
        $state->rts = json_encode($request->rts);
        $state->stage = $request->stage;
        $state->priority = $request->priority;

        $state->save();



    }

    public function newState(Request $request) {
        //add to states table
        try {
            $index = $request->indexInStudyArray;

            $state = new State($request->all());
            $state->accuracyArray = json_encode($state->accuracyArray);
            $state->rtArray = json_encode($state->rtArray);
            $state->subtype = json_encode($state->subtype);
            Auth::user()->states()->save($state);
            return [$state->id, $index];
        }
        catch(Exception $e) {
            $errorMessage = 'Caught exception: ' . $e->getMessage();

            return $errorMessage;
        }



    }

    public function postAction(Request $request) {
    	//posts action to actions table
        try {
            $action = new Action();
            $action->state_id = $request->state_id;
            $action->type = $request->type;
            $action->detail = json_encode($request->detail);
            $action->time = $request->time;
            Auth::user()->actions()->save($action);
            return ['saved successfully'];
        }
        catch(Exception $e) {
            $errorMessage = 'Caught exception: ' . $e->getMessage();

            return $errorMessage;
        }


    }

}
