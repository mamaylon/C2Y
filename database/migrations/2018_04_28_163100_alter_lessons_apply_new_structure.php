<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLessonsApplyNewStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) 
        {
            $table->string('photoType')->nullable();
            $table->string('model')->nullable();
            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();
            $table->text('goals')->nullable();            
            $table->text('suggestions')->nullable();
            $table->text('resources')->nullable();
            $table->boolean('owner');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) 
        {   
            $table->dropColumn('owner');
            $table->dropColumn('resources');
            $table->dropColumn('suggestions');
            $table->dropColumn('goals');
            $table->dropColumn('age_max');
            $table->dropColumn('age_min');
            $table->dropColumn('model');
            $table->dropColumn('photoType');            
        });
    }
}
