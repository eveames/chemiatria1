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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/home/report', 'HomeController@email_progress');

//Route::get('words-create-error', 'WordController@create_error');
