<?php

namespace C2Y\Http\Controllers\API;

use C2Y\Http\Controllers\API\APIController;
use C2Y\User;
use C2Y\Lesson;
use C2Y\Course;
use Illuminate\Http\Request;
use C2Y\Http\Controllers\Controller;

class CustomController extends Controller {
    public function me($user) {
        try {
            $lessons = Lesson::me($user);
            $courses = Course::me($user);
            return APIController::success([
                'lessons' => $lessons,
                'courses' => $courses
            ]);
        } catch (Exception $e) {
            return APIController::error($e->getMessage());
        }
    }

    public function user ($id) {
        $user = User::get($id);
        $arr = $user->toArray();
        $arr['classrooms'] = $user->classrooms->toArray();
        return APIController::success(['user' => $user]);
    }
}
