<?php

namespace C2Y\Http\Controllers\API;

use C2Y\Topic;
use Illuminate\Http\Request;
use C2Y\Http\Controllers\Controller;
use C2Y\Http\Requests\StoreSampleRequest;
use C2Y\Http\Controllers\API\APIController;

class TopicController extends Controller
{
    /**
    * @api {get} /api/topic All
    * @apiName allTopics
    * @apiDescription Request all topics information
    * @apiGroup Topic
    *
    * @apiSampleRequest http://localhost:8000/api/topic

    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Object[]} data.topics List of lessons.
    * @apiSuccess {Number} data.topics.id ID of the created lesson.
    * @apiSuccess {String} data.topics.name  Name of the Lesson.
    */
    public function index()
    {
        $all = Topic::all();
        return APIController::success(['topics' => $all]);
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
    * @api {post} /api/topic Create
    * @apiName createTopic
    * @apiDescription Create a topic
    * @apiGroup Topic
    *
    * @apiSampleRequest http://localhost:8000/api/topic
    *
    * @apiParam {String} name  Name of the Concept.
    * {
    *   "name": "Geografia"
    * }
    *
    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Number} data.id ID of the created topic.
    */
    public function store(StoreSampleRequest $request)
    {
        $data = $request->all();
        try {
            $topic = Topic::create($data);
            return APIController::success(['id' => $topic->id]);
        }
        catch (Exception $e) {
            return APIController::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
