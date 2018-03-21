<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOneColoumProjectidItemfileEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_file_entry', function (Blueprint $table) {
            $table->string('projectId')->nullable();
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
            $table->dropColumn('projectId');
        });
    }
}
