<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
  use Traits\Classroom;
  protected $table = 'classes';
  public $incrementing = false;
  protected $fillable = ['name', 'school', 'code'];

  /**
   * The users that belong to the classroom.
   */
  public function users()
  {
    return $this->belongsToMany('C2Y\User', 'classes_users', 'class_id', 'user_id')
    	->withPivot('role');
  }

  public static function show ($id = null) {
  	$builder = self::with(['users']);
  	if ($id) {
  		return $builder->where('id', $id)->first();
  	}
  	return $builder->get();
  }
}
