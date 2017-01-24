<?php

namespace chemiatria\Http\Controllers;

use chemiatria\Word;
use Illuminate\Http\Request;
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
        return view('words.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //// validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'word'       => 'required|unique:words',
            'prompts'      => 'required',
        );
        //$validator = Validator::make(Input::all(), $rules);

        // process the login
        $this->validate($request, $rules);
        
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
    public function update(Request $request, Word $word)
    {
        //
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
    }
}
