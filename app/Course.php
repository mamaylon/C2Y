<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;
use DB;

class Course extends Model
{
  use Traits\Uuids;
  public $incrementing = false;

  protected $fillable = [ 'name', 'photo', 'description', 'user_id' ];

  /**
  * Get the user that owns the lesson.
  */
  public function students() {
    return $this->belongsToMany('C2Y\User', 'courses_users');
  }

  /**
   * Get all of the course's likes.
   */
  public function likes () {
    return $this->morphMany('C2Y\Like', 'likable');
  }

  /**
  * Get the user that owns the lesson.
  */
  public function user()
  {
    return $this->belongsTo('C2Y\User');
  }

  /**
  * The lessons that belong to the course.
  */
  public function lessons()
  {
    return $this->belongsToMany('C2Y\Lesson', 'lessons_courses')
      ->withPivot('level');
  }

  public static function me ($user) {
    return self::where('user_id', $user)
      ->get();
  }

  public static function show ($params, $max) {
    // $relations = [];
    $page = isset($params['page']) ? intval($params['page']) : 0;
    $params['page'] = null;
    $user = false;
    $builder = self::select('*', DB::raw('count(1) over() as count'))->limit($max)->offset($max * $page);

    if (isset($params['user'])) {
      $builder = self::getComplete($builder, $params['user']);
      $user = $params['user'];
      unset($params['user']);
    }

    if (isset($params['concepts'])) {
      $concepts = $params['concepts'];
      $builder = $builder->whereHas('lessons', function ($q) use ($concepts) {
        $q->join('concepts_lessons', 'lessons.id', '=', 'concepts_lessons.lesson_id')
          ->join('concepts', 'concepts_lessons.concept_id', '=', 'concepts.id');
        $q->where(function ($query) use ($concepts) {
          foreach ($concepts as $c) {
            $query->orWhere('concepts.name', $c);
          }
        });
      });
      unset($params['concepts']);
    }
    if (isset($params['types'])) {
      unset($params['types']);
    }

    foreach ($params as $key => $value) {
      if ($value)
        $builder = $builder->where($key, 'ilike', "%$value%");
    }

    $builder = $builder->withCount('likes');
    if (!$user)
      return $builder->get();

    return array_map(function ($item) {
      $item['student'] = count($item['students']) > 0;
      // $item['liked'] = $item['likes'] > 0;
      $item['likes'] = $item['likes_count'];
      unset($item['students']);
      unset($item['likes_count']);
      return $item;
    }, $builder->get()->toArray());
  }

  // Retorna se o estudante esta matriculado no curso
  public static function getComplete ($builder, $user) {
    return $builder->with(['students' => function ($q) use ($user) {
      $q->select('id')->where('id', $user);
    }]);
  }

  // Find course to given user
  public static function findForUser($id, $user) {
    $builder = Course::where('id', $id);
    $builer = $builder->where(function ($q) use ($user) {
      $q->whereHas('students', function ($query) use ($user) {
        $query->where('id', $user);
      })->orWhere('user_id', $user);
    });
    $builder = $builder->with(['likes' => function ($query) use ($user) {
      $query->where('user_id', $user);
    }]);
    $result = $builder->get();
    if (count($result) === 0)
      return null;
    $result[0]->likes_count = $result[0]->likes()->count();
    return $result[0];
  }
}
