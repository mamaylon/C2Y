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

  public static function getBuilder ($all) {
    if ($all) {
      return self::with(['users']);
    }
    return self::with(['users' => function ($q) {
      $q->where('role', 'master');
    }]);
  }

  public static function show ($id = null, $all = false) {
  	$builder = self::getBuilder($all);
  	if ($id) {
  		return $builder->where('id', $id)->first();
  	}
  	return $builder->get();
  }
}
