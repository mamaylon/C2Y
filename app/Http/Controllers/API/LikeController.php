<?php

namespace C2Y\Http\Controllers\API;

use Illuminate\Http\Request;
use C2Y\Http\Controllers\API\APIController;
use C2Y\Http\Controllers\Controller;
use C2Y\Like;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Like::all();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all = $request->all();
        $map = [
            'user' => 'user_id',
            'to' => 'likable_id',
            'type' => 'likable_type'
        ];
        $required = ['user', 'to', 'type'];
        $resp = APIController::verify($required, $all, $map);
        if (!$resp) {
            return APIController::error('Required params not found');
        }
        $like = Like::create($resp);
        return APIController::success(['like' => $like]);
        //
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
    public function destroy ($id) {
        Like::destroy($id);
    }
}
