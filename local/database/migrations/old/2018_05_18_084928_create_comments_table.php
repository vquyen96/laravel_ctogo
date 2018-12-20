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
            $table->increments('comment_id');
            $table->tinyInteger('comment_rate');
            $table->text('comment_content');
            $table->integer('comment_homestay_id')->unsigned();
            $table->foreign('comment_homestay_id')
                  ->references('homestay_id')
                  ->on('homestay')
                  ->onDelete('cascade');
            $table->integer('comment_user_id')->unsigned();
            $table->foreign('comment_user_id')
                  ->references('id')
                  ->on('users')
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
        Schema::dropIfExists('comments');
    }
}
