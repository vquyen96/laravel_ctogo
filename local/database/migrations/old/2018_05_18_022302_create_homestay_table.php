<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomestayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homestay', function (Blueprint $table) {
            $table->increments('homestay_id');
            $table->string('homestay_name')->nullable();
            $table->tinyInteger('homestay_type')->nullable();
            $table->text('homestay_about')->nullable();
            $table->string('homestay_image')->nullable();
            $table->string('homestay_location')->nullable();
            $table->string('homestay_facility')->nullable();
            $table->text('homestay_rule')->nullable();
            $table->integer('homestay_user_id')->unsigned();
            $table->foreign('homestay_user_id')
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
         Schema::dropIfExists('homestay');
    }
}
