<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBnccComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bncc_components', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');            
            $table->string('name');
            $table->string('cod');            
            $table->text('description');

            $table->timestamps();
        });

        Schema::create('lesson_bncc_component', function (Blueprint $table) {
            $table->uuid('lesson_id');
            $table->foreign('lesson_id')
                    ->references('id')
                    ->on('lessons')
                    ->onDelete('cascade');

            $table->uuid('bncc_component_id');
            $table->foreign('bncc_component_id')
                    ->references('id')
                    ->on('bncc_components')
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
        Schema::dropIfExists('lesson_bncc_component');
        Schema::dropIfExists('bncc_components');        
    }
}
