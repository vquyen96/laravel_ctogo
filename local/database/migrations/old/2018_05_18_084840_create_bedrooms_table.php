<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBedroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bedrooms', function (Blueprint $table) {
            $table->increments('bedroom_id');
            $table->string('bedroom_name');
            $table->string('bedroom_bedtype');
            $table->string('bedroom_image');
            $table->integer('bedroom_slot');
            $table->string('bedroom_bath');
            $table->string('bedroom_description');
            $table->string('bedroom_facility',1000);
            $table->string('bedroom_price');
            $table->integer('bedroom_homestay_id')->unsigned();
            $table->foreign('bedroom_homestay_id')
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
        Schema::dropIfExists('bedrooms');
    }
}