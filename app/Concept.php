<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
