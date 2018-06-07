<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use Traits\Uuids;
    public $incrementing = false;
    protected $fillable = ['user_id', 'likable_type', 'likable_id'];

    /**
     * Get all of the owning likable models.
     */
    public function likable () {
        return $this->morphTo();
    }

    /**
     * Get the user that owns the like.
    */
    public function user () {
        return $this->belongsTo('C2Y\User');
    }
}
