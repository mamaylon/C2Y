<?php

namespace C2Y\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user = Auth::user();
    $classrooms = $user
      ->classrooms()
      ->with(['users' => function ($q) {
        $q->where('role', 'master');
      }])
      ->get();

    $classrooms = $classrooms->map(function ($item, $index) {
      $item->master = $item->users[0];
      unset($item->master->pivot);
      unset($item->users);
      unset($item->pivot);
      return $item;
    });

    $user->classrooms = $classrooms;
    return view('app')
      ->withUser( $user->toJson() );
  }
}
