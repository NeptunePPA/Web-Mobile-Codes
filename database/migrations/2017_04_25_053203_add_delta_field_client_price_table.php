<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeltaFieldClientPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_price', function (Blueprint $table) {
            $table->enum('unit_cost_delta_check', ['True', 'False'])->default('False');
            $table->enum('cco_delta_check', ['True', 'False'])->default('False');
            $table->enum('cco_discount_delta_check', ['True', 'False'])->default('False');
            $table->enum('unit_repless_delta_check', ['True', 'False'])->default('False');
            $table->enum('unit_repless_discount_delta_check', ['True', 'False'])->default('False');
            $table->enum('system_cost_delta_check', ['True', 'False'])->default('False');
            $table->enum('system_repless_delta_check', ['True', 'False'])->default('False');
            $table->enum('system_repless_discount_delta_check', ['True', 'False'])->default('False');
            $table->enum('reimbursement_delta_check', ['True', 'False'])->default('False');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('client_price');
    }
}
