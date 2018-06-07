<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class LessonReference extends Model
{
    use Traits\Uuids;
	public $incrementing = false;
	
    protected $fillable = [
        'link',
        'description' 
    ];
}
