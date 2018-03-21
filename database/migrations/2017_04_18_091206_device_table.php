<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('device', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('level_name', ['Entry Level', 'Advanced Level']);
            $table->integer('project_name')->unsigned();
            // $table->foreign('project_name')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('category_name')->unsigned();
            // $table->foreign('category_name')->references('id')->on('category')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('manufacturer_name')->unsigned();
            // $table->foreign('manufacturer_name')->references('id')->on('manufacturers')->onDelete('cascade')->onUpdate('cascade');
            $table->string('device_name');
            $table->string('model_name');
            $table->string('device_image');
            $table->integer('rep_email')->unsigned()->nullable();
            // $table->foreign('rep_email')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['Enabled', 'Disabled'])->default("Disabled");
            $table->string('exclusive')->nullable();
            $table->string('exclusive_check');
            $table->integer('longevity')->nullable();
            $table->string('longevity_check');
            $table->string('shock')->nullable();
            $table->string('shock_check');
            $table->string('size')->nullable();
            $table->string('size_check');
            $table->string('research')->nullable();
            $table->string('research_check');
            $table->string('website_page')->nullable();
            $table->string('website_page_check');
            $table->string('url')->nullable();
            $table->enum('overall_value', ['Low','Medium','High'])->default("Medium");
            $table->string('overall_value_check')->nullable();
            $table->integer('is_delete');
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
        Schema::dropIfExists('device');
    }
}
