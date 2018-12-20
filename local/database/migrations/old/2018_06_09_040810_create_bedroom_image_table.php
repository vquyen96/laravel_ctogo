<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBedroomImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bedroom_images', function (Blueprint $table) {
            $table->increments('bedroom_image_id');
            $table->string('bedroom_image_img');
            $table->integer('bedroom_image_bedroom_id')->unsigned();
            $table->foreign('bedroom_image_bedroom_id')
                  ->references('bedroom_id')
                  ->on('bedrooms')
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
        Schema::dropIfExists('bedroom_images');
    }
}
