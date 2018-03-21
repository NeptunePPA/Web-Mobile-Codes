<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('manufacturer_name')->unsigned()->nullable();
            // $table->foreign('manufacturer_name')->references('id')->on('manufacturers')->onDelete('cascade');
            $table->string('model_name');
            $table->string('model_no');
            $table->double('unit_cost', 8, 2);
            $table->double('system_cost', 8, 2);
            $table->double('cco', 8, 2);
            $table->double('reimbursement', 8, 2);
            $table->date('order_date');
            $table->integer('orderby')->unsigned()->nullable();
            // $table->foreign('orderby')->references('id')->on('users')->onDelete('cascade');
            $table->integer('rep')->unsigned()->nullable();
            // $table->foreign('rep')->references('id')->on('users')->onDelete('cascade');
            $table->string('sent_to');
            $table->enum('status', ['New', 'Complete','Cancelled']);
            $table->enum('bulk_check', ['True', 'False']);
            $table->integer('is_delete');
            $table->integer('is_archive');
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
        Schema::dropIfExists('orders');
    }
}
