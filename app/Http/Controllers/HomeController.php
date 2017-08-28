<?php

namespace chemiatria\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use chemiatria\Mail\Report;
use Illuminate\Support\Facades\Session;
use chemiatria\State;
use chemiatria\Topic;
use chemiatria\Helpers\SessionPlanHelper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SessionPlanHelper $formatter)
    {
        $user = auth()->user();
        $numDueToReview = $formatter->checkDue($user);
        return view('home')->with('user', auth()->user())->with('numDueToReview', $numDueToReview);
    }

    public function email_progress()
    {
        $user = auth()->user();
        Mail::to($user)->send(new Report($user));
        Session::flash('message', 'Successfully emailed!');
        return view('home')->with('user', auth()->user());
    }

    public function play()
    {
      return view('home.play')->with('user', auth()->user());
    }

    public function playall()
    {
      //first, reset session to include all states
      $user = auth()->user();
      $user->states()->update(['current' => 1]);
      return view('home.play')->with('user', auth()->user());
    }

    public function plan(SessionPlanHelper $formatter)
    {
      //dd('inside plan');
      $user = auth()->user();
      $data = $formatter->formatProgress($user);
      $newTopics = $formatter->organizeNew($user);
      //dd($data);
      return view('home.plan')->with('user', $user)
        ->with('data', $data)->with('new', $newTopics);
    }
    public function update_plan(Request $request, SessionPlanHelper $formatter)
    {
      $user = auth()->user();
      //create new states
      if(is_array($request->new))
      {
        //dd($request->new);
        $topicIDsToAdd = array_map('intval', array_keys($request->new));
        $user = auth()->user();
        $formatter->addStatesByTopic($topicIDsToAdd, $user);
      }

      //update current on old states
      $input = json_decode($request->input, true);
      //dd($input);
      $data = $request->data;

      //dd($data, $input);

      //unseen:
      $statesToSet1 = [];
      $statesToSet0 = [];
      if(isset($data['unseen']) && is_array($data['unseen']))
        {
          $unseenUnset = array_diff_key($input['unseen'], $data['unseen']);
          //dd($unseenUnset, $input, $data);
          foreach($unseenUnset as $arr)
          {
            //dd($arr);
            $statesToSet0 = array_merge($statesToSet0, array_keys($arr));
          }
          //dd($statesToSet0);
        }
      if(isset($data['due']) && is_array($data['due']))
        {
          $dueSet = array_intersect_key($input['due'], $data['due']);
          foreach ($dueSet as $arr) {
            $statesToSet1 = array_merge($statesToSet1, array_keys($arr));
          }
          $dueUnset = array_diff_key($input['due'], $data['due']);
          foreach ($dueUnset as $arr) {
            $statesToSet0 = array_merge($statesToSet0, array_keys($arr));
          }
        }
      if(isset($data['prev']) && is_array($data['prev']))
        {
          $prevUnset = array_diff_key($input['prev'], $data['prev']);
          foreach ($prevUnset as $arr) {
            $statesToSet0 = array_merge($statesToSet0, array_keys($arr));
          }
        }
      if(isset($data['other']) && is_array($data['other']))
        {
          $otherSet = array_intersect_key($input['other'], $data['other']);
          foreach ($otherSet as $arr) {
            $statesToSet1 = array_merge($statesToSet1, array_keys($arr));
          }
        }
      $statesToSet1 = array_filter($statesToSet1, function($item) {
        return(is_numeric($item));
      });
      $statesToSet0 = array_filter($statesToSet0, function($item) {
        return(is_numeric($item));
      });
      //dd($statesToSet1, $statesToSet0);
      if($statesToSet1 != [])
      {
        //State::findOrFail($statesToSet1)->update(['current', 1]);
        State::whereIn('id', $statesToSet1)->update(['current' => 1]);
      }
      if($statesToSet0 != [])
      {
        State::whereIn('id', $statesToSet0)->update(['current' => 0]);
        //dd($states);
        //$states;
      }
      //dd($user->states()->get());
      return view('home')->with('user', $user);

    }
    public function detail_plan($id, SessionPlanHelper $formatter)
    {
      $user = auth()->user();
      $topic = Topic::find($id);
      $data = $formatter->topicDetail($topic, true, true);
      //dd($data);
      return view('home.detail')->with('user', $user)->with('data', $data);
    }

    public function update_detail_plan(Request $request, SessionPlanHelper $formatter)
    {
      $user = auth()->user();
      dd($request);
    }
}
