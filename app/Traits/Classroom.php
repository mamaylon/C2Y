<?php
namespace C2Y\Traits;
use Webpatser\Uuid\Uuid;

trait Classroom
{
    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{ $model->getKeyName() } = Uuid::generate()->string;
            $model->code = strtoupper(str_random(6));
        });
    }
}