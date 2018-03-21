<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeltaFeatureDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_features', function (Blueprint $table) {
            $table->enum('longevity_delta_check', ['True', 'False'])->default('False')->nullable();
            $table->enum('shock_delta_check', ['True', 'False'])->default('False')->nullable();
            $table->enum('size_delta_check', ['True', 'False'])->default('False')->nullable();
            $table->enum('research_delta_check', ['True', 'False'])->default('False')->nullable();
            $table->enum('site_info_delta_check', ['True', 'False'])->default('False')->nullable();
            $table->enum('overall_value_delta_check', ['True', 'False'])->default('False')->nullable();
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
            $table->dropColumn('longevity_delta_check');
            $table->dropColumn('shock_delta_check');
            $table->dropColumn('size_delta_check');
            $table->dropColumn('research_delta_check');
            $table->dropColumn('site_info_delta_check');
            $table->dropColumn('overall_value_delta_check');
        });
    }
}
