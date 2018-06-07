<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_files', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');            
            $table->string('type');
            $table->text('file');
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
        Schema::dropIfExists('lesson_files');
    }
}
