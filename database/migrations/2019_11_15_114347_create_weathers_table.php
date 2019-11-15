<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeathersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weathers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('place_id')->unsigned();
            $table->string('icon')->nullable();
            $table->timestamp('sunset_at');
            $table->timestamp('sunrise_at');
            $table->integer('temperature');
            $table->integer('humidity');
            $table->integer('pressure');
            $table->integer('wind_speed');
            $table->integer('wind_degree');
            $table->integer('clouds_percent')->nullable();
            $table->timestamp('status_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weathers');
    }
}
