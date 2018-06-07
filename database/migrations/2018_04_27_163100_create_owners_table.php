<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');
            $table->string('email');

            $table->timestamps();
        });

        Schema::create('lesson_owner', function (Blueprint $table) {
            $table->uuid('lesson_id');
            $table->foreign('lesson_id')
                    ->references('id')
                    ->on('lessons')
                    ->onDelete('cascade');

            $table->uuid('owner_id');
            $table->foreign('owner_id')
                    ->references('id')
                    ->on('owners')
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
        Schema::dropIfExists('lesson_owner');
        Schema::dropIfExists('owners');
    }
}
