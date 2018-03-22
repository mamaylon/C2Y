<?php

namespace C2Y\Http\Controllers\API;

use Illuminate\Http\Request;
use C2Y\Http\Controllers\Controller;
use C2Y\Http\Controllers\API\APIController;

// Models
use C2Y\Classroom;

class ClassController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request) {
    $all = Classroom::show(null, $request->users == 'true' || $request->users === true);
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
    $class = Classroom::create($all);
    try {
      $class->users()->sync([
        $request->user => [ 'role' => 'master' ]
      ]);
      return APIController::success(['classroom' => $class]);
    } catch (\Exception $err) {
      return APIController::error('user must be a unique UUID');
    }
  }

  public function color ($code, $color) {
    $color = isset($color) ? '#'.$color : null;
    Classroom::where('code', $code)
      ->update(['color' => $color]);
    return APIController::success();
  }

  public function sync (Request $request) {
    $all = $request->all();
    $all = APIController::verify(['user', 'code'], $all);
    if (!$all) {
      return APIController::error('Required field not found. Request must contain "code" and "user"');
    }
    $class = Classroom::where('code', $request->code)
      ->with(['users' => function ($q) {
        $q->where('role', 'master');
      }])
      ->first();
    if (!$class) {
      return APIController::error('Classroom not found');
    }
    $class->master = $class->users[0];
    unset($class->users);
    unset($class->pivot);
    unset($class->master->pivot);

    try {
      $role = $request->role ? $request->role : 'student';
      $class->users()->sync([$request->user => ['role' => $role]], false);
      return APIController::success([ 'classroom' => $class ]);
    }
    catch (Exception $e) {
      return APIController::error($e->getMessage());
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
    $class = Classroom::show($id, true);
    if (!$class) {
      return APIController::error('Classroom not found');
    }
    if (count($class->courses)) {
      $class->course = $class->courses[0];
      unset($class->courses);
      unset($class->course->pivot);
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

  // Associate a course whith the classroom
  public function associate (Request $request) {
    $required = ['classroom', 'course'];
    $arr = APIController::verify($required, $request->all());
    if (!$arr) {
      return APIController::errorRequired($required);
    }
    $classroom = Classroom::find($request->classroom);
    if (!$classroom) {
      return APIController::error('Classroom not found');
    }
    try {
      $classroom->courses()->sync($request->course);
      return APIController::success(['classroom' => $classroom]);
    }
    catch (Exception $e) {
      return APIController::error($e->getMessage());
    }
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
