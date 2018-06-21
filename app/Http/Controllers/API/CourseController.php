<?php

namespace C2Y\Http\Controllers\API;

use C2Y\Course;
use C2Y\Lesson;
use Illuminate\Http\Request;
use C2Y\Http\Controllers\Controller;
use C2Y\Http\Requests\StoreCourseRequest;
use C2Y\Http\Controllers\ImageController;
use C2Y\Http\Controllers\API\APIController;

class CourseController extends Controller
{
    private $results_per_page = 16;

    function __construct() {
        // $this->middleware('auth:api', ['except' => ['index','show']]);
    }

    /**
    * @api {get} /api/course All
    * @apiName AllCourses
    * @apiGroup Course
    *
    * @apiSuccess {Number} id ID of the Course.
    * @apiSuccess {String} name  Name of the Course.
    * @apiSuccess {String} created_at  Creation date of the Course.
    * @apiSuccess {String} updated_at  Update of the Course.
    */
    public function index(Request $request)
    {
        $all = $request->all();
        $user = 0;
        if (isset($all['user']))
            $user = intval($all['user']);

        $courses = Course::show($all, $this->results_per_page);
        return APIController::success(['courses' => $courses]);
    }

    public function sync(Request $request) {
        //novas informações
        $data = $request->course;

        //informações do banco
        $course = Course::find($data['id']);
       
        if (!$course)
            return APIController::error('Course not found');
        if ($course->user_id != $request->user)
            return APIController::error('User denied');
        
        // Upload se foto é diferente
        if ($request->update && $course->photo != $data['photo']) {
            ImageController::delete($request->photo);
            $data['photo'] = ImageController::upload($data['photo']);
        }
        
        //preenche a versão do banco com as novas informações e persiste no banco
        if ($request->update) {
            $course->fill($data);
            $course->save();
        }

        $arr = [];
        $data = [];
        $course->lessons()->sync([]);
        foreach ($request->lessons as $act) 
        {
            if (isset( $arr[ $act['lesson'] ] )) 
            {
                $data[] = $course->lessons()->attach($arr);
                $arr = [];
            }
            
            $arr[ $act['lesson'] ] = [ 'level' => $act['level'] ];
        }

        $data[] = $course->lessons()->attach($arr);
        return APIController::success($data);
    }

    public function registry(Request $request) {
        $course = Course::find($request->course);
        if (!$course)
            return APIController::error('Course not found.');
        if (!$request->user)
            return APIController::error('"user" param not found.');
        $user = $request->user;
        $data[] = $course->students()->sync([ $user ], false);
        return APIController::success($data);
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
    * @api {post} /api/course Create
    * @apiName createCourse
    * @apiDescription Create a course
    * @apiGroup Course
    *
    * @apiSampleRequest http://localhost:8000/api/course
    *
    * @apiParam {String} name  Name of the Course.
    * @apiParam {String} [description]  Optional description of the Course.
    * @apiParam {String} [link]  Optional link of the Course.
    * @apiParamExample {json} Request-Example:
    * {
    *   "name": "Brincando com cores"
    *   "description": "Nesta atividade você deve selecionar as cores exibidas durante o jogo para..."
    *   "link": "http://scratch.io/brincando-com-cores"
    * }
    *
    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Number} data.id ID of the created course.
    */
    public function store(StoreCourseRequest $request)
    {
        $info = $request->all();
        $info['photo'] = ImageController::upload($request->get('photo'));
        $lesson = Course::create($info);
        return APIController::success(['id' => $lesson->id ]);
    }

    /**
    * @api {get} /api/course/:id Retrieve
    * @apiDescription Request course information
    * @apiName getCourse
    * @apiGroup Course
    *
    * @apiSampleRequest http://localhost:8000/api/course/1
    *
    * @apiSuccess {Number} id ID of the Course.
    * @apiSuccess {String} name  Name of the Course.
    * @apiSuccess {String} created_at  Creation date of the Course.
    * @apiSuccess {String} updated_at  Update of the Course.
    */
    public function show(Request $request, $id)
    {
        $course = Course::findForUser($id, $request->user);
        if (!$course) {
            $course = Course::findForClassroom($id, $request->user);
        }
        if (!$course) {
            return APIController::error('Course not found to given user', 403);
        }
        $arr = $course->toArray();
        $arr['liked'] = count($course->likes) ? $course->likes[0] : null;
        $arr['likes'] = $course->likes_count;
        if ($request->lessons) {
            $arr['lessons'] = $course->lessons->toArray();//$course['lessons'] = Lesson::show([ 'course' => $id, 'user' => $request->user ]);
            foreach ($course->lessons as $k => $item) {
                $a = $item->completeds;
                $arr['lessons'][$k]['completeds'] = count($a) > 0;
            }
        }
        return APIController::success([ 'course' => $arr ]);
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
    public function destroy(Request $request, $id)
    {
        $course = Course::find($id);
        if (!$request->user)
            return APIController::error('"user" param not found');
        if (!$course)
            return APIController::error('Course no found');
        if ($course->id != $id)
            return APIController::error('Not allowed');
        return APIController::success([ $course->forceDelete() ]);
    }

    /**
    * @api {get} /api/course/:id Request course information
    * @apiName getCourse
    * @apiGroup Course
    *
    * @apiSampleRequest http://localhost:8000/api/course/1
    *
    * @apiSuccess {Number} id ID of the Course.
    * @apiSuccess {String} name  Name of the Course.
    * @apiSuccess {String} created_at  Creation date of the Course.
    * @apiSuccess {String} updated_at  Update of the Course.
    */

}
