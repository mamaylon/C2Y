<?php

namespace C2Y\Http\Controllers\API;

use C2Y\Concept;
use Illuminate\Http\Request;
use C2Y\Http\Requests\StoreSampleRequest;
use C2Y\Http\Controllers\Controller;
use C2Y\Http\Controllers\API\APIController;

class ConceptController extends Controller
{
    /**
    * @api {get} /api/concept All
    * @apiName allConcepts
    * @apiDescription Request all concepts information
    * @apiGroup Concept
    *
    * @apiSampleRequest http://localhost:8000/api/concept

    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Object[]} data.concepts List of lessons.
    * @apiSuccess {Number} data.concepts.id ID of the created lesson.
    * @apiSuccess {String} data.concepts.name  Name of the Lesson.
    */
    public function index()
    {
        $all = Concept::all();
        return APIController::success(['concepts' => $all]);
    }

    /**
    * @api {post} /api/concept Create
    * @apiName createConcept
    * @apiDescription Create a concept
    * @apiGroup Concept
    *
    * @apiSampleRequest http://localhost:8000/api/concept
    *
    * @apiParam {String} name  Name of the Concept.
    * {
    *   "name": "Computação desplugada"
    * }
    *
    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Number} data.id ID of the created concept.
    */
    public function store(StoreSampleRequest $request)
    {
        $data = $request->all();
        try {
            $concept = Concept::create($data);
            return APIController::success(['id' => $concept->id]);
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
