<?php

namespace C2Y\Http\Controllers\API;

use C2Y\Lesson;
use C2Y\Comment;
use C2Y\Http\Controllers\API\APIController;
use Illuminate\Http\Request;
use C2Y\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comments = Comment::show($request->user);
        return APIController::success(['comments' => $comments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
    * @api {post} /api/comment/lesson Create
    * @apiName createComment
    * @apiDescription Create a comment
    * @apiGroup Comment
    *
    * @apiSampleRequest http://localhost:8000/api/comment/lesson/1
    *
    * @apiParam {String} body Body of the comment.
    * {
    *   "body": "Muito legal, parabéns :)"
    * }
    *
    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Number} data.id ID of the created concept.
    */
    public function store(Request $request, $id)
    {
        $lesson = Lesson::find($id);
        if (!$lesson)
            return APIController::error("Lesson not exit's");
        $comment = new Comment($request->all());
        $lesson->comments()->save($comment);
        return APIController::success(['id' => $comment->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
