<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomContactInofrmationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_contact_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clientId')->unsigned();
            // $table->foreign('clientId')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('deviceId')->unsigned();
            // $table->foreign('deviceId')->references('id')->on('device')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('order_email')->unsigned()->nullable();
            // $table->foreign('order_email')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('cc1')->nullable();
            $table->string('cc2')->nullable();
            $table->string('cc3')->nullable();
            $table->string('cc4')->nullable();
            $table->string('cc5')->nullable();
            $table->string('subject')->nullable();
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
        Schema::drop('custom_contact_info');
    }
}
