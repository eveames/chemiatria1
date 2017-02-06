<?php

namespace chemiatria\Http\Controllers;

use chemiatria\Word;
use chemiatria\Altword;
use chemiatria\Topic;
use Illuminate\Http\Request;
use chemiatria\Http\Requests\CreateWord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

//use Collective\Html;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // show only matches to search
        if($request->search) 
        {
            $search = $request->search; //<-- we use global request to get the param of URL
            
            $searchArray = explode('; ', $search);
            
            $words = DB::table('words')->whereIn('word', $searchArray)->get();
            $topics = DB::table('topics')->whereIn('topic', $searchArray)->get();
            $alternates = Altword::with('word')->whereIn('alt', $searchArray)->get();
            
            $request->session()->flash('message', 'You searched for ' . $search . '.');
            
        }
        //show all
        else {
            $words = Word::all();
            $alternates = false;
            $topics = Topic::orderBy('id')->get();
        }
        return view('words.index')->with('words', $words)->with('alternates', $alternates)->with('topics', $topics);
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
            return redirect(url('words'));
        }
        return view('words.create')->with('topics', $topics);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWord $request)
    {
        // store
        $word = new Word;
        $word->word = $request->word;
        $word->prompts = json_encode(explode("; ", $request->prompts));
        $word->save();
        $topicIDs = array_keys($request->topic);
        foreach($topicIDs as $id)
        {
            $word->topics()->attach($id);
        }

        // redirect
        Session::flash('message', 'Successfully added word!');
        return redirect(url('words/' . $word->id . '/edit/'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \chemiatria\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function show(Word $word)
    {
        //
        return view('words.show')
            ->with('word', $word)->with('altwords', $word->altwords)->with('topics', $word->topics);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \chemiatria\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function edit(Word $word)
    {

        //authorize
        $user = Auth::user();
        if($user->cant('edit_word')){
            return redirect(url('words/' . $word->id));
        }
        // show the edit form and pass the word, alts and topics
        
        $nonTopics = Topic::whereNotIn('id', $word->topics->modelKeys())->orderBy('id')->get();
        return view('words.edit')
            ->with('word', $word)->with('altwords', $word->altwords)
            ->with('topics', $word->topics)->with('nonTopics', $nonTopics);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \chemiatria\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // authorize
        $user = Auth::user();
        if($user->cant('edit_word')){
            return redirect(url('words/' . $word->id));
        }
        // validate!!
        // currently doesn't validate alts; should fix this
        $rules = [
                    'prompts'      => 'required',
                    'topic'    =>'required_without:nonTopic',

                ];
        $this->validate($request, $rules);

        // store
        $path = $request->path();
        $array = explode('/',$path);
        $id = array_pop($array);
        $word = Word::find($id);
        $prompts = $request->prompts;
        $newPrompts = explode("; ", $request->newPrompts);
        $prompts = array_merge($prompts, $newPrompts);
        $word->prompts = json_encode($prompts);

        //store topics

        $word->save();
        $alts = $word->altwords()->get();
        $data = array_filter($request->all());
        $altArray = array_filter($data, function($k){
            return preg_match('/altword/', $k) ;
        }, ARRAY_FILTER_USE_KEY);
        $newAltArray = array_filter($data, function($k){
            return preg_match('/newAltword/', $k);
        }, ARRAY_FILTER_USE_KEY);

        foreach($alts as $alt)
        {
            $alt->correct = $altArray['altwords' . $alt->id . 'correct'];
            if (isset($altArray['altwords' . $alt->id . 'message']))
                {$alt->message = $altArray['altwords' . $alt->id . 'message'];}
            $alt->save();
        }

        for($i = 0; $i < 3; $i++)
        {
            if(!isset($newAltArray['newAltwords' . $i . 'alt'])) {break;}
            $alt = new Altword;
            $alt->alt = $newAltArray['newAltwords' . $i . 'alt'];
            $alt->correct = $newAltArray['newAltwords' . $i . 'correct'];
            if (isset($newAltArray['newAltwords' . $i . 'message']))
                {$alt->message = $newAltArray['newAltwords' . $i . 'message'];}
        }

        $oldTopics = $word->topics()->get();
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
            {$word->topics()->detach($oldTopic->id);}
        }

        foreach($newTopicIDs as $id)
        {
            $word->topics()->attach($id);
        }
        // redirect
        Session::flash('message', 'Successfully updated!');
        return redirect(url('words/' . $word->id . '/edit/'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \chemiatria\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function destroy(Word $word)
    {
        //
        $user = Auth::user();
    }

    public function create_error(Request $request)
    {
        $word = Word::where('word', $request->old('word'));
        return view('words.create')->with($request)->with($word);
    }

    public function topic_search($id)
    {
        $topic = Topic::find($id);
        $topics = [$topic];
        $words = $topic->words()->get();
        $alternates = false;
        return view('words.index')->with('words', $words)->with('alternates', $alternates)->with('topics', $topics);

    }

    public function __construct() {
        //add middleware here
        $this->middleware('auth');
    }
}
