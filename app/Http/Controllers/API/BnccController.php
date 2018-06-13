<?php

namespace C2Y\Http\Controllers\API;

use C2Y\BnccComponent;
use Illuminate\Http\Request;
use C2Y\Http\Requests\StoreBnccRequest;
use C2Y\Http\Controllers\Controller;
use C2Y\Http\Controllers\API\APIController;

class BnccController extends Controller
{
 	/**
    * @api {get} /api/concept All
    * @apiName allConcepts
    * @apiDescription Request all concepts information
    * @apiGroup Concept
    *
    * @apiSampleRequest http://localhost:8000/api/bncc

    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Object[]} data.concepts List of lessons.
    * @apiSuccess {Number} data.concepts.id ID of the created lesson.
    * @apiSuccess {String} data.concepts.name  Name of the Lesson.
    */
    public function index()
    {
        $all = BnccComponent::all()->sortBy("name");
        return APIController::success(['bncc_components' => $all]);
    }

    public function jsonSelect()
    {
    	$all = BnccComponent::all()->sortBy("name");
        $jsonReturn = array();
    	
        foreach ($all as $bncc) 
    	{
            $jsonReturn[] = array("name"=>$bncc['name']." (".$bncc['cod'].")", "id"=>$bncc['id']);
    	}

        return json_encode($jsonReturn);
    }

    /**
    * @api {post} /api/bncc Create
    * @apiName createConcept
    * @apiDescription Create a bncc_component
    * @apiGroup bncc
    *
    * @apiSampleRequest http://localhost:8000/api/bncc
    *
    * @apiParam {String} name  Name of the Concept.
    * {
    *   "description": "Matematica"
    * }
    *
    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Number} data.id ID of the created concept.
    */
    public function store(StoreBnccRequest $request)
    {
        $data = $request->all();
        try 
        {
            $bncc = BnccComponent::create($data);
            return APIController::success(['id' => $bncc->id]);
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