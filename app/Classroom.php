<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
  use Traits\Classroom;
  protected $table = 'classes';
  public $incrementing = false;
  protected $fillable = ['name', 'school', 'code', 'color'];

  /**
   * The users that belong to the classroom.
   */
  public function users()
  {
    return $this->belongsToMany('C2Y\User', 'classes_users', 'class_id', 'user_id')
    	->withPivot('role');
  }

  /**
  * Get the courses that owns the classroom.
  */
  public function courses() {
    return $this->belongsToMany('C2Y\Course', 'classes_courses', 'class_id', 'course_id');
  }


  public static function getBuilder ($all) {
    if ($all) {
      return self::with(['users'])
        ->with(['courses' => function ($q) {
          $q->select(['name', 'photo', 'id', 'level', 'lesson']);
        }]);
    }
    return self::with(['users' => function ($q) {
      $q->where('role', 'master');
    }]);
  }

  public static function findWithOwner ($id, $user) {
    if (!$user) {
      return null;
    }
    return self::where('id', $id)
      ->whereHas('users', function ($q) use ($user) {
        $q->where('id', $user)->where('role', 'master');
      })
      ->first();
  }

  public static function show ($id = null, $all = false) {
  	$builder = self::getBuilder($all);
  	if ($id) {
  		return $builder->where('id', $id)->first();
  	}
  	return $builder->get();
  }
}
