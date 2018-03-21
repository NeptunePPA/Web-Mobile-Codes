<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepCaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rep_case_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('caseId');
            $table->date('procedureDate');
            $table->integer('clientId')->unsigned();
            // $table->foreign('clientId')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('physicianId')->unsigned();
            // $table->foreign('physicianId')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('categoryId')->unsigned();
            // $table->foreign('categoryId')->references('id')->on('category')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('manufacturerId')->unsigned();
            // $table->foreign('manufacturerId')->references('id')->on('manufacturers')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('rep_case_details');
    }
}
