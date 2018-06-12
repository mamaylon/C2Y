<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPcAndBnccTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bncc_components', function (Blueprint $table) 
        {
            $table->string('cod')->nullable();
            $table->string('name')->nullable();
        });

        Schema::table('pc_components', function (Blueprint $table) {
            $table->string('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pc_components', function (Blueprint $table) {
            $table->dropColumn('name');
        });
        
        Schema::table('bncc_components', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('cod');
        });
    }
}
