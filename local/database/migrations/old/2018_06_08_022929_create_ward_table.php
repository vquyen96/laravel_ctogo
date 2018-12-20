<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ward', function (Blueprint $table) {
            $table->increments('ward_id');
            $table->string('ward_name');
            $table->string('ward_slug');
            $table->string('ward_code')->unique();
            $table->integer('ward_district_id')->unsigned();
            $table->foreign('ward_district_id')
                  ->references('district_id')
                  ->on('district')
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
        Schema::dropIfExists('ward');
    }
}
