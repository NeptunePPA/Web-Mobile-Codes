<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewSwapdateitemfileEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_file_entry', function (Blueprint $table) {
            $table->date('newSwapDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_file_entry', function (Blueprint $table) {
           $table->dropColumn('newSwapDate');
        });
    }
}
