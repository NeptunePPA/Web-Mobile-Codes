<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItemFileMain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::enableForeignKeyConstraints();

        Schema::create('item_file_main', function (Blueprint $table) {
            $table->increments('id');
            $table->string('repcaseID');
            $table->string('produceDate');
            $table->integer('clientId')->nullable();
            $table->string('physician');
            $table->string('category');
            $table->string('manufacturer');
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
        Schema::drop('item_file_main');
    }
}
