<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFiledsClientprice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_price', function (Blueprint $table) {
            $table->enum('unit_cost_highlight', ['True', 'False'])->default('False');
            $table->enum('bulk_highlight', ['True', 'False'])->default('False');
            $table->enum('cco_highlight', ['True', 'False'])->default('False');
            $table->enum('cco_discount_highlight', ['True', 'False'])->default('False');
            $table->enum('unit_repless_highlight', ['True', 'False'])->default('False');
            $table->enum('unit_repless_discount_highlight', ['True', 'False'])->default('False');
            $table->enum('system_cost_highlight', ['True', 'False'])->default('False');
            $table->enum('system_bulk_highlight', ['True', 'False'])->default('False');
            $table->enum('system_repless_highlight', ['True', 'False'])->default('False');
            $table->enum('system_repless_discount_highlight', ['True', 'False'])->default('False');
            $table->enum('reimbursement_highlight', ['True', 'False'])->default('False');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_price', function (Blueprint $table) {
            //
        });
    }
}
