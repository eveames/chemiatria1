<?php

namespace chemiatria\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use chemiatria\Word;
use chemiatria\Http\Controllers\WordController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class CreateWord extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create_word');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {    
        return [
            'word'       => 'bail|required|unique:words',
            'prompts'      => 'required',
            'topic'    =>'required'
        ];
    }

    public function messages()
    {
        return [
            'word.required' => 'You must enter a word',
            'word.unique'   => 'That word already exists. Please edit it instead',
            'prompts.required'  => 'You must enter at least one prompt',
            'topic.required'    => 'You must select at least one topic',
        ];
    }

    //protected $word = Word::where('word', $request->old('word'));
    //protected $redirectTo = view('words.create')->with($request)->with($word);

    //protected $redirectAction = 'WordController@create_error';

    /*protected function getRedirectUrl()
    {
        $word = Word::where('word', $this->old('word'));
        $url = $this->redirector->getUrlGenerator();
        dd($url);

        return $url->route('words.create', $word);
    }*/
}
