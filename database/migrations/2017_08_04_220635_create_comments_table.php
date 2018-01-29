<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('body');
            $table->uuid('receiver');
            $table->foreign('receiver')->references('id')
                ->on('users')->onDelete('cascade');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->uuid('commentable_id');
            $table->string('commentable_type');
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
        Schema::dropIfExists('comments');
    }
}
