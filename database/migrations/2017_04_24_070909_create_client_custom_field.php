<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientCustomField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_custom_field', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned();
            // $table->foreign('device_id')->references('id')->on('device')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('client_name')->unsigned();
            // $table->foreign('client_name')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->string('field_check');
            $table->integer('c_id')->unsigned();
            // $table->foreign('c_id')->references('id')->on('device_custom_field')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('client_custom_field');
    }
}
