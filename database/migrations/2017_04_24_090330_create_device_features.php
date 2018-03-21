<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_features', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned();
            // $table->foreign('device_id')->references('id')->on('device')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('client_name')->unsigned();
            // $table->foreign('client_name')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('longevity_check', ['True', 'False'])->nullable()->default('False');
            $table->enum('shock_check', ['True', 'False'])->nullable()->default('False');
            $table->enum('size_check', ['True', 'False'])->nullable()->default('False');
            $table->enum('research_check', ['True', 'False'])->nullable()->default('False');
            $table->enum('siteinfo_check', ['True', 'False'])->nullable()->default('False');
            $table->enum('overall_value_check', ['True', 'False'])->nullable()->default('False');
            $table->string('is_created');
            $table->string('is_updated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_features');
    }
}
