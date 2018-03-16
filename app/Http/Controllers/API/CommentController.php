<?php

namespace C2Y\Http\Controllers\API;

use C2Y\Lesson;
use C2Y\Comment;
use C2Y\Http\Controllers\API\APIController;
use Illuminate\Http\Request;
use C2Y\Http\Controllers\Controller;

class CommentController extends Controller
{
  private $required = ['type', 'id', 'body', 'user'];
  private $map = [
    'user' => 'user_id',
    'type' => 'commentable_type',
    'id' => 'commentable_id'
  ];

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index (Request $request) {
    $required = ['type', 'id'];
    $map = ['type' => 'commentable_type', 'id' => 'commentable_id'];
    $arr = APIController::verify($required, $request->all(), $map);
    if (!$arr) {
      return APIController::errorRequired($required);
    }
    $comments = Comment::show($arr);
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
  public function store(Request $request)
  {
    // $lesson = Lesson::find($id);
    // if (!$lesson)
    //     return APIController::error("Lesson not exit's");
    $arr = APIController::verify($this->required, $request->all(), $this->map);
    if (!$arr) {
      return APIController::errorRequired($this->required);
    }
    $comment = new Comment($arr);
    $comment->save();
    $comment->user;
    return APIController::success(['comment' => $comment]);
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
  public function update(Request $request, $id) {
    $arr = APIController::verify($this->required, $request->all(), $this->map);
    if (!$arr) {
      return APIController::errorRequired($this->required);
    }
    $rows = Comment::where('id', $id)->update($arr);
    if ($rows) {
      return APIController::success(['comment' => $rows]);
    }
    return APIController::error('comment not found');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {
    $rows = Comment::destroy($id);
    if ($rows) {
      return APIController::success(['comment' => $rows]);
    }
    return APIController::error('comment not found');
  }
}
