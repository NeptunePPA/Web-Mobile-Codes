<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Physcianspreferenceanswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physciansPreferenceAnswer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clientId')->unsigned()->nullable();
            $table->integer('deviceId')->unsigned()->nullable();
            $table->integer('userId')->unsigned()->nullable();
            $table->string('question')->nullable();
            $table->enum('check',['True','False'])->defult('True');
            $table->enum('answer',['True','False'])->defult('False');
            $table->integer('preId')->unsigned()->nullable();
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
        Schema::drop('physciansPreferenceAnswer');
    }
}
