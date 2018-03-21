<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_no');
            $table->string('client_name');
            $table->text('street_address');
            $table->string('city');
            $table->integer('state')->unsigned();
            $table->foreign('state')->references('id')->on('state')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('is_active');
            $table->integer('is_delete');
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
        Schema::dropIfExists('clients');
    }
}
