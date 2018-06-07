<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_references', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->text('description');
            $table->string('link');
            $table->uuid('lesson_id');
            $table->foreign('lesson_id')
                    ->references('id')
                    ->on('lessons')
                    ->onDelete('cascade');

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
        Schema::dropIfExists('lesson_references');
    }
}
