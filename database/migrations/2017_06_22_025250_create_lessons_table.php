<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Create topics */
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        /* Create lessons */
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('age')->nullable();
            $table->string('photo')->nullable();
            $table->string('link')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        /* Create lessons_topics */
        Schema::create('lessons_topics', function (Blueprint $table) {
            $table->integer('lesson_id')->unsigned()->nullable();
            $table->foreign('lesson_id')->references('id')
                ->on('lessons')->onDelete('cascade');
            
            $table->integer('topic_id')->unsigned()->nullable();
            $table->foreign('topic_id')->references('id')
                ->on('topics')->onDelete('cascade');
            
            $table->primary(['lesson_id', 'topic_id']);
            $table->timestamps();
        });

        /* Create courses */
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('photo')->nullable();
            $table->text('description');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        /* Create courses_users */
        Schema::create('lessons_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('level')->unsigned();
            
            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id')->references('id')
                ->on('courses')->onDelete('cascade');
            
            $table->integer('lesson_id')->unsigned()->nullable();
            $table->foreign('lesson_id')->references('id')
                ->on('lessons')->onDelete('cascade');
            
            $table->timestamps();
        });

        /* Create courses_users */
        Schema::create('courses_users', function (Blueprint $table) {
            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id')->references('id')
                ->on('courses')->onDelete('cascade');
            
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            
            $table->primary(['course_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses_users');
        Schema::dropIfExists('lessons_courses');
        Schema::dropIfExists('lessons_topics');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('topics');
        Schema::dropIfExists('lessons');
    }
}
