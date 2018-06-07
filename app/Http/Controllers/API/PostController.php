<?php

namespace C2Y\Http\Controllers\API;

use Illuminate\Http\Request;
use C2Y\Http\Controllers\Controller;
use C2Y\Http\Controllers\API\APIController;
use C2Y\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $all = $request->all();
        $response = APIController::verify(['id', 'type'], $all);
        if (!$response) {
            return APIController::error('Required field not found. Request must contain "id" and "type"');
        }
        $posts = Post::show($request->id, $request->type);
        $posts = $posts->map(function ($item) {
            $new = [];
            $new['comments_count'] = $item->comments_count;
            $new['text'] = $item->text;
            $new['id'] = $item->id;
            $new['attachments'] = $item->attachments;
            $new['created_at'] = $item->created_at;
            $new['user'] = $item->user;
            return $new;
        });
        return APIController::success(['posts' => $posts]);
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
            'id' => 'postable_id',
            'type' => 'postable_type'
        ];
        $required = [
            'id',
            'type',
            'text',
            'user_id'
        ];
        $response = APIController::verify($required, $all, $map);
        if (!$response) {
            return APIController::error('Required field not found. Request must contain "id", "type", "text", "user_id"');
        }
        try {
            $post = Post::create($response);
            $post->user;
            return APIController::success(['post' => $post]);
        } catch (Exception $err) {
            return APIController::error($err->getMessage());
        }
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) {
        $post = Post::findById($id);
        return APIController::success([
            'posts' => [$post]
        ]);
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
        try {
            $post = Post::where('id', $id)
                ->update($request->all());
            return APIController::success(['post' => $post]);
        } catch (Exception $e) {
            return APIController::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            return APIController::success(['post' => Post::destroy($id)]);
        } catch (Exception $err) {
            return APIController::error($err->getMessage());
        }
    }

    public function upload (Request $request) {
        $file = $request->file('archive');
        $filename = $file->getClientOriginalName();
        $path = Storage::putFile('files', $file);
        return APIController::success([
            'path' => $path,
            'filename' => $filename
        ]);
    }
}
