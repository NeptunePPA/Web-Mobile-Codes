<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientIdSerialidSerialdetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serialDetail', function (Blueprint $table) {
            $table->integer('serialId')->unsigned();
            $table->foreign('serialId')->references('id')->on('serialNumber')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('clientId')->unsigned();
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
        Schema::table('serialdetail', function (Blueprint $table) {
            $table->dropColumn('serialId');
            $table->dropColumn('clientId');

        });
    }
}
