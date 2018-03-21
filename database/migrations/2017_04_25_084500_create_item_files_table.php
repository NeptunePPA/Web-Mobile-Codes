<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clientId')->unsigned();
            // $table->foreign('clientId')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->string('itemFile');
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
        Schema::drop('item_files');
    }
}
