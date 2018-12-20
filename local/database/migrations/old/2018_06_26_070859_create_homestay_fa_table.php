<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomestayFaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homestay_fa', function (Blueprint $table) {
            $table->increments('homestay_fa_id');
            $table->integer('homestay_fa_homestay_id')->unsigned();
            $table->foreign('homestay_fa_homestay_id')
                  ->references('homestay_id')
                  ->on('homestay')
                  ->onDelete('cascade');
            $table->integer('homestay_fa_homestay_facility_id')->unsigned();
            $table->foreign('homestay_fa_homestay_facility_id')
                  ->references('facility_id')
                  ->on('facility')
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
        Schema::dropIfExists('homestay_fa');
    }
}