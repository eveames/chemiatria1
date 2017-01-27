<?php

namespace chemiatria\Http\Controllers;

use chemiatria\Word;
use chemiatria\Altword;
use Illuminate\Http\Request;
use chemiatria\Http\Requests\CreateWord;
use Illuminate\Support\Facades\Auth;

//use Collective\Html;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //show all words; will be a lot!
        $words = Word::all();
        return view('words.index')
            ->with('words', $words);

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
        //Session::flash('message', 'Successfully added word!');
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
        // store
        //dd($request);
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
        dd($request->all());
        foreach($request->altwords as $alt)
        {
            $altword = Altword::where('alt', $alt->alt)->first();
            $altword->correct = $alt->correct;
            $altword->message = $alt->message;
            $altword->save();
        }

        foreach($request->newAltwords as $alt)
        {
            $altword = new Altword;
            $altword->alt = $alt->alt;
            $altword->word_id = $word->id;
            $altword->correct = $alt->correct;
            $altword->message = $alt->message;
            $altword->save();
        }

        // redirect
        //Session::flash('message', 'Successfully updated!');
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
