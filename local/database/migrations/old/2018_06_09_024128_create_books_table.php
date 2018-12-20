<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('book_id');
            $table->tinyInteger('book_status');
            $table->string('book_from');
            $table->string('book_to');
            $table->integer('book_slot');
            $table->integer('book_bedroom_id')->unsigned();
            $table->foreign('book_bedroom_id')
                  ->references('bedroom_id')
                  ->on('bedrooms')
                  ->onDelete('cascade');
            $table->integer('book_user_id')->unsigned();
            $table->foreign('book_user_id')
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
        Schema::dropIfExists('books');
    }
}
