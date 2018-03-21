<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RepContactInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('rep_contact_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deviceId')->unsigned();
            // $table->foreign('deviceId')->references('id')->on('device')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('repId')->unsigned();
            // $table->foreign('repId')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('repStatus', ['Yes', 'No'])->default('No');
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
        Schema::drop('rep_contact_info');
    }
}
