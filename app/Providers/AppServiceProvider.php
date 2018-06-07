<?php

namespace C2Y\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'lesson' => 'C2Y\Lesson',
            'course' => 'C2Y\Course',
            'classroom' => 'C2Y\Classroom',
            'post' => 'C2Y\Post'
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
