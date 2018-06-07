<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Create classes table */
        Schema::create('classes', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');
            $table->string('school');
            $table->string('code');
            $table->timestamps();
        });

        /* Create associative class/user table */
        Schema::create('classes_users', function (Blueprint $table) {
            /* Pivot info */
            $table->string('role')->default('student');

            $table->uuid('class_id')->nullable();
            $table->foreign('class_id')->references('id')
                ->on('classes')->onDelete('cascade');

            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');

            $table->primary(['class_id', 'user_id']);
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
        Schema::dropIfExists('classes_users');
        Schema::dropIfExists('classes');
    }
}
