<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Traits\Uuids;
    public $incrementing = false;
    protected $fillable = ['user_id', 'text', 'attachments', 'postable_type', 'postable_id'];

    /**
     * Get all of the owning postable models.
     */
    public function postable () {
        return $this->morphTo();
    }

    /**
     * Get the user that owns the post.
    */
    public function user () {
        return $this
            ->belongsTo('C2Y\User');
    }

    public static function show ($id, $type) {
        return self::with('user')
            ->where('postable_id', $id)
            ->where('postable_type', $type)
            ->orderBy('created_at', 'desc')
            ->withCount('comments')
            ->get();
    }

    public static function findById ($id) {
        return self::with('user')
            ->where('id', $id)
            ->with(['comments' => function ($q) {
                $q->with('user')
                    ->orderBy('created_at', 'desc');
            }])
            ->first();
    }

    /**
     * Get all of the post's comments.
    */
    public function comments () {
        return $this->morphMany('C2Y\Comment', 'commentable');
    }

}
