<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class LessonImage extends Model
{
	use Traits\Uuids;
	public $incrementing = false;
	
    protected $fillable = [
        'name',
        'type',
        'file'        
    ];

}
