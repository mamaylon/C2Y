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

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
}); 

// Courses routes
Route::resource('course', 'API\CourseController');
Route::post('course/sync', 'API\CourseController@sync');
Route::post('course/registry', 'API\CourseController@registry');

// Lesson routes
Route::post('lesson/complete/{id}', 'API\LessonController@complete');
Route::post('lesson/alter/{id}', 'API\LessonController@update');

Route::resource('lesson', 'API\LessonController');

// Like route
Route::resource('like', 'API\LikeController');

// Concept/Topic route
Route::resource('concept', 'API\ConceptController');
Route::resource('topic', 'API\TopicController');

// Bncc route
Route::get('bncc/json', 'API\BnccController@jsonSelect');
Route::resource('bncc', 'API\BnccController');

// Pc route
Route::get('pc/json', 'API\PcController@jsonSelect');
Route::resource('pc', 'API\PcController');

//owner route
Route::get('owner/json', 'API\OwnerController@jsonSelect');
Route::resource('owner', 'API\OwnerController');

// Comments route
Route::resource('comment', 'API\CommentController');
Route::put('comment/visualized/{id}', 'API\CommentController@visualized');

// Class route
Route::resource('classroom', 'API\ClassController');
Route::post('classroom/{code}/color/{color?}', 'API\ClassController@color');
Route::post('classroom/sync', 'API\ClassController@sync');
Route::post('classroom/associate', 'API\ClassController@associate');

// Post route
Route::post('post/upload', 'API\PostController@upload');
Route::resource('post', 'API\PostController');

// Custom api routes
Route::get('me/{user}', 'API\CustomController@me');
Route::put('user/{id}', 'API\CustomController@updateUser');
Route::get('/user/{id}', 'API\CustomController@user');
Route::get('/notification/{user}', 'API\CustomController@notification');
Route::post('/bug', 'API\CustomController@bug');
