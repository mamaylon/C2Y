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
Route::resource('lesson', 'API\LessonController');
Route::post('lesson/complete/{id}', 'API\LessonController@complete');

// Like route
Route::resource('like', 'API\LikeController');

// Concept/Topic route
Route::resource('concept', 'API\ConceptController');
Route::resource('topic', 'API\TopicController');

// Comments route
Route::resource('comment', 'API\CommentController');

// Class route
Route::resource('classroom', 'API\ClassController');
Route::post('classroom/{code}/color/{color?}', 'API\ClassController@color');
Route::post('classroom/sync', 'API\ClassController@sync');

// Post route
Route::resource('post', 'API\PostController');
