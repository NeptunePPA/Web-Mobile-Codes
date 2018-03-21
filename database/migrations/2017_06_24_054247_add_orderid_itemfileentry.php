<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderidItemfileentry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_file_entry', function (Blueprint $table) {
            $table->integer('orderId')->unsigned()->nullable();
            // $table->foreign('orderId')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->string('oldOrderStatus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_file_entry',function(Blueprint $table){
            $table->dropColumn('orderId');
            $table->dropColumn('oldOrderStatus');
        });
    }
}
