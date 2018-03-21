<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeviceidSurveyanswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('survey_answer', function (Blueprint $table) {
           
            $table->integer('deviceId')->unsigned();
            // $table->foreign('deviceId')->references('id')->on('device')->onDelete('cascade')->onUpdate('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survey_answer',function(Blueprint $table){
            $table->dropColumn('deviceId');
        });
    }
}
