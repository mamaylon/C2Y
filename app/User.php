<?php

namespace C2Y;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Traits\Uuids;
  use Notifiable;
  public $incrementing = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [ 'name', 'email', 'password', 'birthday', 'photo' ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [ 'password', 'remember_token' ];

  /**
   * Get the lessons for the user.
   */
  public function lessons()
  {
    return $this->hasMany('C2Y\Lesson');
  }

  /**
   * Get the lessons for the user.
   */
  public function likes()
  {
    return $this->hasMany('C2Y\Like');
  }

  /**
   * The classrooms that belong to the user.
   */
  public function classrooms()
  {
    return $this->belongsToMany('C2Y\Classroom', 'classes_users', 'user_id', 'class_id')
      ->withPivot('role');
  }

  public function toArray () {
    $attributes = $this->attributesToArray();
    if ($this->pivot) {
      $attributes['role'] = $this->pivot->role;
    }
    // $attributes = array_merge($attributes, $this->relationsToArray());
    // unset($attributes['pivot']['created_at']);
    return $attributes;
  }

  public static function get ($id) {
    return self::where('id', $id)
      ->with('classrooms')
      ->first();
  }
}
