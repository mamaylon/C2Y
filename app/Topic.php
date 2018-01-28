<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
