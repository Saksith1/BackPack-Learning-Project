<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            // $table->unsignedBigInteger('trainer_id');
            // $table->foreign('trainer_id')
            // ->references('id')
            // ->on('trainers');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->unsignedBigInteger('trainer_id');
            // $table->foreign('trainer_id')
            // ->references('id')
            // ->on('trainers');

            $table->string('title');
            $table->text('body');
            $table->text('image')->nullable();
            $table->text('created_by')->nullable();
            $table->text('updated_by')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
