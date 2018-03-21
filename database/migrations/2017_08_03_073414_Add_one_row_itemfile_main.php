<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOneRowItemfileMain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_file_main', function (Blueprint $table) {
            $table->string('projectId')->nullable();
            $table->dropColumn('category');
            $table->dropColumn('manufacturer');

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
            $table->dropColumn('projectId');
            $table->string('manufacturer')->nullable();
            $table->string('category')->nullable();
        });
    }
}
