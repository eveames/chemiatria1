<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => 'auth', 'prefix' => 'api/student'], function () {
	  Route::get('words', 'ApiController@getWords');
    Route::get('words/{topic_id}', 'ApiController@getWordsByTopic');
    Route::get('topics', 'ApiController@getTopics');
    Route::get('states', 'ApiController@getStates');
    Route::post('states', 'ApiController@updateAllStates');
    Route::post('states/new', 'ApiController@newState');
    Route::post('states/{id}', 'ApiController@updateState');
    Route::post('actions', 'ApiController@postAction');
});
