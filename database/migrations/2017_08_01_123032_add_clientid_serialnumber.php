<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientidSerialnumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serialNumber', function (Blueprint $table) {
            $table->integer('clientId')->unsigned()->nullable();
//            $table->foreign('clientId')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serialnumber', function (Blueprint $table) {
            $table->dropColumn('clientId');
        });
    }
}
