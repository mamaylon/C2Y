<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pc_components', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');
            $table->text('description');

            $table->timestamps();
        });

        Schema::create('lesson_pc_component', function (Blueprint $table) {
            $table->uuid('pc_component_id');
            $table->foreign('pc_component_id')
                    ->references('id')
                    ->on('pc_components')
                    ->onDelete('cascade');

            $table->uuid('lesson_id');
            $table->foreign('lesson_id')
                    ->references('id')
                    ->on('lessons')
                    ->onDelete('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_pc_component');
        Schema::dropIfExists('pc_components');        
    }
}
