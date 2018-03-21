<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeviceidSerialnumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serialNumber', function (Blueprint $table) {
            $table->integer('deviceId')->unsigned()->nullable();
//             $table->foreign('deviceId')->references('id')->on('device')->onDelete('cascade');
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
            $table->dropColumn('deviceId');
        });
    }
}
