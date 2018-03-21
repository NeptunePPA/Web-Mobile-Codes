<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Devicerequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_request', function (Blueprint $table) {
            $table->increments('id');
            $table->string('projectName')->nullable();
            $table->string('categoryName')->nullable();
            $table->string('deviceName')->nullable();
            $table->string('message')->nullable();
            $table->integer('userId')->unsigned()->nullable();
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
        Schema::dropIfExists('device_request');
    }
}
