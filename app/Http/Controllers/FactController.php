<?php

namespace chemiatria\Http\Controllers;

use Illuminate\Http\Request;
use chemiatria\Topic;
use chemiatria\Fact;
//use chemiatria\Http\Requests\CreateWord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class FactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // show only matches to search
        $facts = Fact::orderBy('group_name')->get();
        $topics = Topic::orderBy('id')->get();
        return view('facts.index')->with('facts', $facts)->with('topics', $topics);
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
            return redirect(url('facts'));
        }
        return view('facts.create')->with('topics', $topics);
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
        $fact = new Fact;
        $fact->group_name = $request->group_name;
        $fact->key = $request->key;
        $fact->key_name = $request->key_name;
        $fact->prop = $request->prop;
        $fact->prop_name = $request->prop_name;
        $fact->save();
        $topicIDs = array_keys($request->topic);
        foreach($topicIDs as $id)
        {
            $fact->topics()->attach($id);
        }

        // redirect
        Session::flash('message', 'Successfully added fact!');
        return redirect(url('facts/' . $fact->id . '/edit/'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $fact = Fact::find($id);
        return view('facts.show')
            ->with('fact', $fact)->with('topics', $fact->topics);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        //authorize
        $user = Auth::user();
        $fact = Fact::find($id);
        if($user->cant('edit_word')){
            return redirect(url('facts/' . $fact->id));
        }
        // show the edit form and pass the word, alts and topics

        $nonTopics = Topic::whereNotIn('id', $fact->topics->modelKeys())->orderBy('id')->get();
        return view('facts.edit')
            ->with('fact', $fact)
            ->with('topics', $fact->topics)->with('nonTopics', $nonTopics);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $user = Auth::user();
        if($user->cant('edit_word')){
            return redirect(url('facts/' . $fact->id));
        }
        // validate!!
        // currently doesn't validate alts; should fix this
        $rules = [
                    'key'      => 'required',
                    'key_name' => 'required',
                    'prop'      => 'required',
                    'prop_name' => 'required',
                    'group_name' => 'required',
                    'topic'    =>'required_without:nonTopic',

                ];
        $this->validate($request, $rules);

        // store
        $path = $request->path();
        $array = explode('/',$path);
        $id = array_pop($array);
        $fact = Fact::find($id);
        $fact->prop = $request->prop;
        $fact->prop_name = $request->prop_name;
        $fact->key = $request->key;
        $fact->key_name = $request->key_name;
        $fact->group_name = $request->group_name;
        $fact->save();

        //store topics
        $oldTopics = $fact->topics()->get();
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
            {$fact->topics()->detach($oldTopic->id);}
        }

        foreach($newTopicIDs as $id)
        {
            $fact->topics()->attach($id);
        }
        // redirect
        Session::flash('message', 'Successfully updated!');
        return redirect(url('facts/' . $fact->id . '/edit/'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function topic_search($id)
    {
        $topic = Topic::find($id);
        $topics = [$topic];
        $facts = $topic->facts()->get();
        return view('facts.index')->with('facts', $facts)->with('topics', $topics);

    }
}
