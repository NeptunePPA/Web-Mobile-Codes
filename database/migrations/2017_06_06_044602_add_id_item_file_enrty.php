<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdItemFileEnrty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('item_file_entry', function (Blueprint $table) {
            $table->integer('itemMainId')->unsigned()->nullable();
            // $table->foreign('itemMainId')->references('id')->on('item_file_main')->onDelete('cascade')->onUpdate('cascade');
             $table->enum('status', ['itemfile', 'manual'])->default('itemfile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('item_file_entry',function(Blueprint $table){
            $table->dropColumn('itemMainId');
            $table->dropColumn('status');
        });
    }
}
