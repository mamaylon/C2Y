<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use Traits\Uuids;
    public $incrementing = false;  
    public $timestamps = false;
    protected $fillable = ['name'];
}
