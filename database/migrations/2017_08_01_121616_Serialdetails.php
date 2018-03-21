<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Serialdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serialDetail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serialNumber');
            $table->string('status');
//            $table->integer('serialId')->unsigned()->nullable();
//            $table->foreign('serialId')->references('id')->on('serialNumber')->onDelete('cascade')->onUpdate('cascade');
//            $table->integer('clientId')->unsigned();
//            $table->foreign('clientId')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('serialDetail');
    }
}
