<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableImportApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_app_value', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name')->nullable();
            $table->string('project_name')->nullable();
            $table->string('category_avg_app')->nullable();
            $table->string('client_name')->nullable();
            $table->string('device_level')->nullable();
            $table->string('year')->nullable();
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
        Schema::dropIfExists('import_app_value');
    }
}
