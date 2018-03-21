<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColoumItemfileEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_file_entry', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->string('manufacturer')->nullable();
            $table->date('swapDate')->nullable();
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
            $table->dropColumn('category','manufacturer','swapDate');
        });
    }
}
