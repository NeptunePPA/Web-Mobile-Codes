<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiealdInItemEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_file_entry', function (Blueprint $table) {
            $table->enum('isImplanted', ['Implanted', 'Not Implanted'])->default('Implanted');
            $table->enum('type', ['Main', 'Sub'])->nullable();
            $table->enum('unusedReason', ['Dropped', 'Wrong Device','Rep Error','Doctor Error','Damaged Packaging'])->nullable();
        });
    }


    public function down()
    {
        Schema::table('item_file_entry', function (Blueprint $table) {
            $table->dropColumn('isImplanted','type','unusedReason');
        });
    }
}
