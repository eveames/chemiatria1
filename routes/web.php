<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('words', 'WordController');
Route::resource('facts', 'FactController');

Route::get('/words/topics/{id}', 'WordController@topic_search');
Route::get('/facts/topics/{id}', 'FactController@topic_search');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/home/report', 'HomeController@email_progress');

Route::get('/home/play', 'HomeController@play');

Route::get('/home/play/all', 'HomeController@playall');

Route::get('/home/plan', 'HomeController@plan');

Route::post('/home/plan', 'HomeController@update_plan');

Route::group(['middleware' => 'auth', 'prefix' => 'api/student'], function () {
	  Route::get('words', 'ApiController@getWords');
    Route::get('words/{topic_id}', 'ApiController@getWordsByTopic');
    Route::get('facts', 'ApiController@getFacts');
    Route::get('topics', 'ApiController@getTopics');
    Route::get('states', 'ApiController@getStates');
    Route::get('states/active', 'ApiController@getActiveStates');
    Route::post('states', 'ApiController@updateAllStates');
    Route::post('states/new', 'ApiController@newState');
    Route::post('states/{id}', 'ApiController@updateState');
    Route::post('actions', 'ApiController@postAction');
    Route::get('user', 'ApiController@getUser');
});
