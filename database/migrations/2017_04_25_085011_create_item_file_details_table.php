<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemFileDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_files_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company');
            $table->string('category');
            $table->string('supplyItem');
            $table->string('mfgPartNumber')->nullable();
            $table->string('hospitalNumber')->nullable();
            $table->string('doctors')->nullable();
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
        Schema::drop('item_files_details');
    }
}
