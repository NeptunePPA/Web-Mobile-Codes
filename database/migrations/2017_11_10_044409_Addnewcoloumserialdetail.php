<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Addnewcoloumserialdetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serialdetail', function (Blueprint $table) {
            $table->enum('purchaseType',['Bulk','Consignment'])->default('Bulk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serialdetail', function (Blueprint $table) {
            //
        });
    }
}
