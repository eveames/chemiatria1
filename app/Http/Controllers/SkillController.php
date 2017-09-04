<?php

namespace chemiatria\Http\Controllers;

use chemiatria\Skill;
use Illuminate\Http\Request;
use chemiatria\Topic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
         $this->middleware('auth');
     }
    public function index()
    {
        //
        $skills = Skill::with('topics')->get();
        //dd($skills);
        return view('skills.index')->with('skills', $skills);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $topics = Topic::orderBy('id')->get();
        $user = Auth::user();
        if($user->cant('create_word')){
            return redirect(url('skills'));
        }
        return view('skills.create')->with('topics', $topics);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $skill = new Skill;
        $skill->skill = $request->skill;
        $skill->description = $request->description;
        $skill->subtype = $request->subtype;
        $skill->save();
        $topicIDs = array_keys($request->topic);
        foreach($topicIDs as $id)
        {
            $skill->topics()->attach($id);
        }

        // redirect
        Session::flash('message', 'Successfully added skill!');
        return redirect(url('skills/' . $skill->id . '/edit/'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \chemiatria\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {
        //
        $skill = Skill::find($id);
        return view('skills.show')
            ->with('skill', $skill)->with('topics', $skill->topics);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \chemiatria\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        //authorize
        $user = Auth::user();
        $skill = Skill::find($id);
        if($user->cant('edit_word')){
            return redirect(url('skills/' . $skill->id));
        }
        // show the edit form and pass the word, alts and topics

        $nonTopics = Topic::whereNotIn('id', $skill->topics->modelKeys())->orderBy('id')->get();
        return view('skills.edit')
            ->with('skill', $skill)
            ->with('topics', $skill->topics)->with('nonTopics', $nonTopics);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \chemiatria\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        //
        $user = Auth::user();
        if($user->cant('edit_word')){
            return redirect(url('facts/' . $fact->id));
        }
        // validate!!
        // currently doesn't validate alts; should fix this
        $rules = [
                    'skill'      => 'required',
                    'subtype' => 'required',
                    'topic'    =>'required_without:nonTopic',
                ];
        $this->validate($request, $rules);

        // store
        $path = $request->path();
        $array = explode('/',$path);
        $id = array_pop($array);
        $skill = Skill::find($id);
        $skill->skill = $request->skill;
        $skill->description = $request->description;
        $skill->subtype = $request->subtype;
        $skill->save();

        //store topics
        $oldTopics = $skill->topics()->get();
        if (isset($request->topic)){
            $currentTopicIDs = array_keys($request->topic);
        }
        else {$currentTopicIDs = [];}
        if (isset($request->nonTopic)){
            $newTopicIDs = array_keys($request->nonTopic);
        }
        else {$newTopicIDs = [];}

        foreach($oldTopics as $oldTopic)
        {
            if(! in_array($oldTopic->id, $currentTopicIDs))
            {$skill->topics()->detach($oldTopic->id);}
        }

        foreach($newTopicIDs as $id)
        {
            $skill->topics()->attach($id);
        }
        // redirect
        Session::flash('message', 'Successfully updated!');
        return redirect(url('skills/' . $skill->id . '/edit/'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \chemiatria\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
