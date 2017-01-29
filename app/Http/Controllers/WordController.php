<?php

namespace chemiatria\Http\Controllers;

use chemiatria\Word;
use chemiatria\Altword;
use Illuminate\Http\Request;
use chemiatria\Http\Requests\CreateWord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        //show all words; will be a lot!
        //$words = Word::all();
        //return view('words.index')
        //    ->with('words', $words);

        
        if($request->search) 
        {
            $search = $request->search; //<-- we use global request to get the param of URL
            
            $searchArray = explode('; ', $search);
            //dd($searchArray);
            
            $words = DB::table('words')->whereIn('word', $searchArray)->get();
            $alternates = Altword::with('word')->whereIn('alt', $searchArray)->get();
            //dd($alternates);
            $request->session()->flash('message', 'You searched for ' . $search . '.');
            
        }
        else {
            //dd('in else');
            $words = Word::all();
            $alternates = false;
        }
        
        //$words = DB::table('words')->whereIn('word', ['heat', 'energy', 'proton'])->get();
        //dd($words);
        //$words = Word::all();
        return view('words.index')->with('words', $words)->with('alternates', $alternates);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Auth::user();
        if($user->cant('create_word')){
            return redirect(url('words'));
        }
        return view('words.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWord $request)
    {
        
        //$validator = Validator::make(Input::all(), $rules);

        // process the login
        
        /*$rules = array(
            'word'       => 'required|unique:words',
            'prompts'      => 'required',
            );
        $this->validate($request, $rules);*/
        
        // store
        $word = new Word;
        $word->word = $request->word;
        $word->prompts = json_encode(explode("; ", $request->prompts));
        $word->save();

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
            ->with('word', $word)->with('altwords', $word->altwords);
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
        // show the edit form and pass the word
        return view('words.edit')
            ->with('word', $word)->with('altwords', $word->altwords);
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

        // store
        $path = $request->path();
        $array = explode('/',$path);
        $id = array_pop($array);
        $word = Word::find($id);
        //dd($word->prompts);
        $prompts = $request->prompts;
        $newPrompts = explode("; ", $request->newPrompts);
        $prompts = array_merge($prompts, $newPrompts);
        $word->prompts = json_encode($prompts);

        $word->save();
        $altIDs = $word->altwords()->select('id')->get();
        //dd($altIDs);
        //dd($request->all());
        $data = array_filter($request->all());
        $altArray = array_filter($data, function($k){
            return preg_match('/altword/', $k) ;
        }, ARRAY_FILTER_USE_KEY);
        $newAltArray = array_filter($data, function($k){
            return preg_match('/newAltword/', $k);
        }, ARRAY_FILTER_USE_KEY);
        //dd($altArray,$newAltArray);

        foreach($altIDs as $id)
        {
            //dd('$id is: '. $id->id);
            $alt = Altword::find($id);
            //dd($altArray['altwords' . $id->id . 'message']);
            $alt->correct = 'correct';
            $alt->message = $altArray['altwords' . $id->id . 'message'];
            $alt->save();
        }

        for($i = 0; $i < 3; $i++)
        {
            if(! $newAltArray['newAltwords' . $i . 'alt']) {break;}
            $alt = new Altword;
            $alt->alt = $newAltArray['newAltwords' . $i . 'alt'];
            $alt->correct = $newAltArray['newAltwords' . $i . 'correct'];
            $alt->message = $newAltArray['newAltwords' . $i . 'message'];
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

    public function __construct() {
        //add middleware here
        $this->middleware('auth');
    }
}
