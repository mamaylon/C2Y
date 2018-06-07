<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/blockly', function () {
    return view('blockly');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', 'HomeController@index');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/redirect/google', 'SocialAuthController@googleRedirect');
Route::get('/callback', 'SocialAuthController@callback');
Route::get('/callback/google', 'SocialAuthController@googleCallback');
