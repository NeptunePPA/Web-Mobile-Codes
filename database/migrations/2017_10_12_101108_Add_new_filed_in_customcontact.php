<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFiledInCustomcontact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_contact_info', function (Blueprint $table) {
            $table->string('orderNumber')->nullable();
            $table->string('cc1Number')->nullable();
            $table->string('cc2Number')->nullable();
            $table->string('cc3Number')->nullable();
            $table->string('cc4Number')->nullable();
            $table->string('cc5Number')->nullable();
            $table->string('cc6Number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_contact_info', function (Blueprint $table) {
            //
        });
    }
}
