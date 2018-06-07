<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Create concept */
        Schema::create('concepts', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');
        });
        
        /* Create lessons_topics */
        Schema::create('concepts_lessons', function (Blueprint $table) {
            $table->uuid('lesson_id')->nullable();
            $table->foreign('lesson_id')->references('id')
                ->on('lessons')->onDelete('cascade');
            
            $table->uuid('concept_id')->nullable();
            $table->foreign('concept_id')->references('id')
                ->on('concepts')->onDelete('cascade');
            
            $table->primary(['lesson_id', 'concept_id']);
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
        Schema::dropIfExists('concepts_lessons');
        Schema::dropIfExists('concepts');
    }
}
