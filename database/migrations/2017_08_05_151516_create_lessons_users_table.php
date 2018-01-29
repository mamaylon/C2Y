<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Create courses_users */
        Schema::create('lessons_users', function (Blueprint $table) {
            $table->uuid('lesson_id')->nullable();
            $table->foreign('lesson_id')->references('id')
                ->on('lessons')->onDelete('cascade');
            
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            
            $table->primary(['lesson_id', 'user_id']);
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
        Schema::dropIfExists('lessons_users');
    }
}
