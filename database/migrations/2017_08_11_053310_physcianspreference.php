<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Physcianspreference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physciansPreference', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clientId')->unsigned()->nullable();
            $table->integer('deviceId')->unsigned()->nullable();
            $table->string('question')->nullable();
            $table->enum('check',['True','False'])->defult('True');
            $table->enum('flag',['True','False'])->defult('True');
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
        Schema::drop('physciansPreference');
    }
}
