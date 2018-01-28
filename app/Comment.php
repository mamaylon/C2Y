<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [ 'body', 'user_id', 'receiver' ];
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

    public static function show ($user) {
        return self::with(['user'])->whereHas('receiver', function($query) use ($user) {
            $query->where('id', $user);
        })->get();
    }
}
