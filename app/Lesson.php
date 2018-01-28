<?php

namespace C2Y;
use DB;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
  protected $fillable = ['name', 'description', 'link', 'age', 'user_id', 'photo'];
  protected static $integer = ['age'];

  public static function getComplete ($builder, $user) {
    return $builder->with(['completeds' => function ($q) use ($user) {
      $q->select('id')->where('id', $user);
    }]);
  }

  public static function get ($id, $request) {
    $lesson = self::with('user')
      ->where('id', $id);
    if ($request->user)
      $lesson = self::getComplete($lesson, $request->user);
    $lesson = $lesson->get();
    return count($lesson) ? $lesson[0] : null;
  }

  public static function show ($params, $max = false) {
    $relations = ['concepts', 'topics', 'user'];
    $builder = self::select('*', DB::raw('count(1) over() as count'))->with($relations);
    
    if (isset($params['user']))
      $builder = self::getComplete($builder, $params['user']);
    if (isset($params['course'])) {
      $builder = $builder->whereHas('courses', function ($query) use ($params) {
        $query->where('courses.id', $params['course']);
      });
      $params['course'] = null;
    }

    foreach ($params as $k => $param) {
      if (in_array($k, $relations))
        $builder = $builder->whereHas($k, function ($query) use ($param, $k) {
          $query->where('id', $param);
        });
      else if ($k != 'page' && $param && !in_array($k, self::$integer))
        $builder = $builder->where($k, 'ilike', '%'.$param.'%');
      else if ($k != 'page' && $param)
        $builder = $builder->where($k, $param);
      else if ($max)
        $builder = $builder->limit($max)->offset(intval($param) * $max);
    }
    $res = $builder->get();
    return $res;
  }

  /**
    * The topics that belong to the lesson.
    */
  public function topics()
  {
    return $this->belongsToMany('C2Y\Topic', 'lessons_topics');
  }

  /**
  * The concepts that belong to the lesson.
  */
  public function concepts()
  {
    return $this->belongsToMany('C2Y\Concept', 'concepts_lessons');
  }

  /**
  * The users completed that belong to the lesson.
  */
  public function completeds()
  {
    return $this->belongsToMany('C2Y\User', 'lessons_users');
  }

  /**
  * Get the user that owns the lesson.
  */
  public function user()
  {
    return $this->belongsTo('C2Y\User');
  }

  /**
  * Get all of the lesson's comments.
  */
  public function comments()
  {
      return $this->morphMany('C2Y\Comment', 'commentable');
  }
  
  /**
  * Get all of the lesson's courses.
  */
  public function courses()
  {
      return $this->belongsToMany('C2Y\Course', 'lessons_courses')
        ->withPivot('level');
  }
}
