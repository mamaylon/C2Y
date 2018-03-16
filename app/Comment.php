<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Traits\Uuids;
    public $incrementing = false;

    protected $fillable = [ 'body', 'user_id', 'commentable_id', 'commentable_type', 'receiver' ];
    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
    * Get the user that owns the comment.
    */
    public function user()
    {
        return $this->belongsTo('C2Y\User');
    }

    /**
    * Get the receiver that owns the comment.
    */
    public function receiver()
    {
        return $this->belongsTo('C2Y\User', 'receiver');
    }

    public static function show ($params) {
        return self::with(['user'])
            ->where('commentable_type', $params['commentable_type'])
            ->where('commentable_id', $params['commentable_id'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
