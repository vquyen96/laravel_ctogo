<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomestayImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homestay_images', function (Blueprint $table) {
            $table->increments('homestay_image_id');
            $table->string('homestay_image_img');
            $table->integer('homestay_image_homestay_id')->unsigned();
            $table->foreign('homestay_image_homestay_id')
                  ->references('homestay_id')
                  ->on('homestay')
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
        Schema::dropIfExists('homestay_images');
    }
}