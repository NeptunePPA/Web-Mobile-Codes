<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeviceCustom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_custom_field', function (Blueprint $table) {
            $table->string('fieldside')->nullable();
            $table->string('fieldimage')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_custom_field', function (Blueprint $table) {
            $table->dropColumn('fieldimage','fieldside');
        });
    }
}
