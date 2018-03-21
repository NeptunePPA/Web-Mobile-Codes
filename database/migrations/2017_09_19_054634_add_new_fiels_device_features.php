<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFielsDeviceFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_features', function (Blueprint $table) {
            $table->enum('longevity_highlight', ['True', 'False'])->default('False');
            $table->enum('shock_highlight', ['True', 'False'])->default('False');
            $table->enum('size_highlight', ['True', 'False'])->default('False');
            $table->enum('research_highlight', ['True', 'False'])->default('False');
            $table->enum('siteinfo_highlight', ['True', 'False'])->default('False');
            $table->enum('overall_value_highlight', ['True', 'False'])->default('False');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_features', function (Blueprint $table) {
            //
        });
    }
}
