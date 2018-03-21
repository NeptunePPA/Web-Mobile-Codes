<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColoumnSerialDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serialdetail', function (Blueprint $table) {
            $table->string('discount')->nullable();
            $table->string('purchaseDate')->nullable();
            $table->string('expiryDate')->nullable();
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
