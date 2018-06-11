<?php

namespace C2Y;
use DB;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
  use Traits\Uuids;
  public $incrementing = false;
  protected $fillable = ['name', 'description', 'link', 'user_id', 'photo', 'photoType', 'model','goals','suggestions','resources','age_min', 'age_max', 'owner'];
  protected static $integer = ['age'];

  public static function me ($user) {
    return self::where('user_id', $user)
      ->get();
  }

  public static function getComplete ($builder, $user) {
    return $builder->with(['completeds' => function ($q) use ($user) {
      $q->select('id')->where('id', $user);
    }]);
  }

  public static function get ($id, $request) {
    
    $relations = ['bncc_components', 'pc_components', 'lesson_references', 'lesson_images', 'lesson_files','user','owners'];

    $lesson = self::with($relations)->where('id', $id);
    
    if ($request->user)
      $lesson = self::getComplete($lesson, $request->user);
    $lesson = $lesson->get();
    
    return count($lesson) ? $lesson[0] : null;
  }

  public static function show ($params, $max = false) {

    $relations = ['bncc_components','pc_components', 'user'];

    $builder = self::select('*', DB::raw('count(1) over() as count'))->with($relations);

    if (isset($params['user']))
      $builder = self::getComplete($builder, $params['user']);
    if (isset($params['course'])) {
      $builder = $builder->whereHas('courses', function ($query) use ($params) {
        $query->where('courses.id', $params['course']);
      });
      $params['course'] = null;
    }

    foreach ($params as $k => $param) 
    {
      if($k =="ageCheck"){}
      else if($k == "age")
      {
        if(!isset($params['ageCheck']))
        {
          $builder = $builder->whereBetween($k.'_max', $param);
          $builder = $builder->orWhereBetween($k.'_min', $param);  
        }
      }
      else if (in_array($k, $relations))
      {
        $builder = $builder->whereHas($k, function ($query) use ($param, $k) {
          $query->where('id', $param);
        });
      }
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
  * The owners that belong to the lesson.
  */
  public function owners()
  {
    return $this->belongsToMany('C2Y\Owner', 'lesson_owner');
  }

  /**
  * The bncc_components that belong to the lesson.
  */
  public function bncc_components()
  {
    return $this->belongsToMany('C2Y\BnccComponent', 'lesson_bncc_component');
  }

  /**
  * The pc_components that belong to the lesson.
  */
  public function pc_components()
  {
    return $this->belongsToMany('C2Y\PcComponent', 'lesson_pc_component');
  }

  /**
  * The lesson_images that belong to the lesson.
  */
  public function lesson_images()
  {
    return $this->hasMany('C2Y\LessonImage');
  }

  /**
  * The lesson_files that belong to the lesson.
  */
  public function lesson_files()
  {
    return $this->hasMany('C2Y\LessonFile');
  }

  /**
  * The lesson_references that belong to the lesson.
  */
  public function lesson_references()
  {
    return $this->hasMany('C2Y\LessonReference');
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
  public function courses() {
    return $this->belongsToMany('C2Y\Course', 'lessons_courses')
      ->withPivot('level');
  }
}
