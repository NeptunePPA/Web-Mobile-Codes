<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategorySortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_sort', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_number');
            $table->integer('client_name')->unsigned();
            // $table->foreign('client_name')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('category_name')->unsigned();
            // $table->foreign('category_name')->references('id')->on('category')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('category_sort');
    }
}
