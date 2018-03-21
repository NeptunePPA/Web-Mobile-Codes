<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Devicefeatureimage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_feature_image', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exclusiveimage')->nullable();
            $table->string('longevityimage')->nullable();
            $table->string('shockimage')->nullable();
            $table->string('sizeimage')->nullable();
            $table->string('researchimage')->nullable();
            $table->string('websiteimage')->nullable();
            $table->string('urlimage')->nullable();
            $table->string('overallimage')->nullable();
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
        Schema::dropIfExists('device_feature_image');
    }
}
