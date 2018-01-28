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

Route::resource('course', 'API\CourseController');
Route::post('course/sync', 'API\CourseController@sync');
Route::post('course/registry', 'API\CourseController@registry');
Route::resource('lesson', 'API\LessonController');
Route::resource('like', 'API\LikeController');
Route::post('lesson/complete/{id}', 'API\LessonController@complete');
Route::resource('concept', 'API\ConceptController');
Route::resource('topic', 'API\TopicController');
// Route::resource('comment', 'API\CommentController');
Route::post('comment/lesson/{id}', 'API\CommentController@store');
Route::get('comment', 'API\CommentController@index');
// Route::get('/lesson/page/{page}', 'API\LessonController@index');
