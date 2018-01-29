<?php

namespace C2Y;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Traits\Uuids;
    use Notifiable;
    public $incrementing = false;  

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birth_date', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the lessons for the user.
     */
    public function lessons()
    {
        return $this->hasMany('C2Y\Lesson');
    }
    
    /**
     * Get the lessons for the user.
     */
    public function likes()
    {
        return $this->hasMany('C2Y\Like');
    }
}
