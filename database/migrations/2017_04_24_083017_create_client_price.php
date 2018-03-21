<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_price', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned();
            // $table->foreign('device_id')->references('id')->on('device')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('client_name')->unsigned();
            // $table->foreign('client_name')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->float('unit_cost');
            $table->string('unit_cost_check');
            $table->float('bulk_unit_cost');
            $table->string('bulk_unit_cost_check');
            $table->integer('bulk');
            $table->string('bulk_check');
            $table->float('cco_discount');
            $table->float('cco');
            $table->string('cco_check');
            $table->string('cco_discount_check');
            $table->float('unit_rep_cost');
            $table->string('unit_rep_cost_check');
            $table->float('unit_repless_discount');
            $table->string('unit_repless_discount_check');
            $table->float('system_cost');
            $table->integer('system_bulk');
            $table->string('system_bulk_check');
            $table->string('system_cost_check');
            $table->float('bulk_system_cost');
            $table->string('bulk_system_cost_check');
            $table->float('system_repless_cost');
            $table->string('system_repless_cost_check');
            $table->float('system_repless_discount');
            $table->string('system_repless_discount_check');
            $table->text('reimbursement');
            $table->string('reimbursement_check');
            $table->integer('order_email')->unsigned()->nullable();
            // $table->foreign('order_email')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('is_delete');
            $table->string('is_created');
            $table->string('is_updated');
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
        Schema::dropIfExists('client_price');
    }
}
