<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemFileEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_file_entry', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('repcaseID')->unsigned();
            // $table->foreign('repcaseID')->references('id')->on('rep_case_details')->onDelete('cascade')->onUpdate('cascade');
            $table->string('supplyItem');
            $table->string('hospitalPart');
            $table->string('mfgPartNumber');
            $table->string('quantity');
            $table->string('purchaseType');
            $table->string('serialNumber');
            $table->string('poNumber');
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
        Schema::drop('item_file_entry');
    }
}
