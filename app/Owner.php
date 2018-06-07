<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use Traits\Uuids;
	public $incrementing = false;

    protected $fillable = ['name','email'];
}
