<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBedroomFaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bedroom_fa', function (Blueprint $table) {
            $table->increments('bedroom_fa_id');
            $table->integer('bedroom_fa_bedroom_id')->unsigned();
            $table->foreign('bedroom_fa_bedroom_id')
                  ->references('bedroom_id')
                  ->on('bedrooms')
                  ->onDelete('cascade');
            $table->integer('bedroom_fa_bedroom_facility_id')->unsigned();
            $table->foreign('bedroom_fa_bedroom_facility_id')
                  ->references('bedroom_facility_id')
                  ->on('bedroom_facilities')
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
        Schema::dropIfExists('bedroom_fa');
    }
}
