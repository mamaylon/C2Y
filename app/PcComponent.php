<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class PcComponent extends Model
{	
	use Traits\Uuids;
	public $incrementing = false;

    protected $fillable = ['description'];
}
