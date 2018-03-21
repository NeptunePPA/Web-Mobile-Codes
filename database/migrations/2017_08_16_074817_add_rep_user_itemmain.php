<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRepUserItemmain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_file_main', function (Blueprint $table) {
            $table->integer('repUser')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_file_main', function (Blueprint $table) {
            $table->dropColumn('repUser');
        });
    }
}
