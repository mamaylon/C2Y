<?php

namespace C2Y;

use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
  use Traits\Uuids;
  public $incrementing = false;

  protected $fillable = ['bug'];
}
