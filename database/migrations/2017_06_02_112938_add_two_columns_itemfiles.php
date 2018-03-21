<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnsItemFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_files', function (Blueprint $table) {
            $table->string('createDate')->nullable();
            $table->string('updateDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_files',function(Blueprint $table){
            $table->dropColumn('createDate');
            $table->dropColumn('updateDate');
        });
    }
}
