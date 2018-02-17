<?php

namespace C2Y\Http\Controllers\API;

use Illuminate\Http\Request;
use C2Y\Http\Controllers\Controller;
use C2Y\Http\Controllers\API\APIController;

// Models
use C2Y\ClassRoom;

class ClassController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $all = ClassRoom::show();
    return APIController::success(['classrooms' => $all]);
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
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $all = $request->all();
    $all = APIController::verify(['name', 'school', 'user'], $all);
    if (!$all) {
      $message = 'Required field not found. Request must contain "name", "school" and "user"';
      return APIController::error($message);
    }
    $class = ClassRoom::create($all);
    try {
      $class->users()->sync([
        $request->user => [ 'role' => 'master' ]
      ]);
      return APIController::success(['classroom' => $class]);
    } catch (\Exception $err) {
      return APIController::error('user must be a unique UUID');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $class = ClassRoom::show($id);
    if (!$class) {
      return APIController::error('Classroom not found');
    }
    return APIController::success(['classroom' => $class]);
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
    $dropped = Classroom::destroy($id);
    if ($dropped) {
      return APIController::success(['rows' => $dropped]);
    }
    return APIController::error('Classroom not found');
  }
}
