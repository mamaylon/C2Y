<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class BnccComponent extends Model
{
	use Traits\Uuids;
	public $incrementing = false;

    protected $fillable = ['description'];
}
