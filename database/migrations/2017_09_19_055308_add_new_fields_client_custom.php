<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsClientCustom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_custom_field', function (Blueprint $table) {
            $table->enum('fileld_highlight', ['True', 'False'])->default('False')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_custom_field', function (Blueprint $table) {
            //
        });
    }
}
