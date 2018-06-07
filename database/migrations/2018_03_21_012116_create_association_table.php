<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssociationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Create lessons_topics */
        Schema::create('classes_courses', function (Blueprint $table) {
            $table->uuid('class_id')->nullable();
            $table->foreign('class_id')->references('id')
                ->on('classes')->onDelete('cascade');

            $table->uuid('course_id')->nullable();
            $table->foreign('course_id')->references('id')
                ->on('courses')->onDelete('cascade');

            $table->primary(['class_id', 'course_id']);
            $table->integer('level')
                ->unsigned()
                ->default(1);
            $table->integer('lesson')
                ->unsigned()
                ->default(1);
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
        Schema::dropIfExists('classes_courses');
    }
}
