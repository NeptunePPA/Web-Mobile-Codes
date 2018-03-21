<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnItemFileDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_files_details', function (Blueprint $table) {
            $table->integer('fileId')->unsigned()->nullable();
            // $table->foreign('fileId')->references('id')->on('item_files')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('clientId')->unsigned()->nullable();
            // $table->foreign('clientId')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_files_details',function(Blueprint $table){
            $table->dropColumn('fileId');
            $table->dropColumn('clientId');
        });
    }
}
