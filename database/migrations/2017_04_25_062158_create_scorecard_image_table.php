<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScorecardImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('scorecard_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('scorecardId')->unsigned();
            // $table->foreign('scorecardId')->references('id')->on('scorecards')->onDelete('cascade')->onUpdate('cascade');
            $table->string('scorecardImage');
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
        Schema::drop('scorecard_images');
    }
}
