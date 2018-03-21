<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Serialnumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serialNumber', function (Blueprint $table) {
            $table->increments('id');
//            $table->integer('clientId')->unsigned();
//             $table->foreign('clientId')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->string('serialFile');
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
        Schema::drop('serialNumber');
    }
}
