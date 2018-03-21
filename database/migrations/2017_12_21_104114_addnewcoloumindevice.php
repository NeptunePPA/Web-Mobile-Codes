<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Addnewcoloumindevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device', function (Blueprint $table) {
            $table->enum('exclusive_side',['Left','Right'])->default('Right');
            $table->enum('longevity_side',['Left','Right'])->default('Right');
            $table->enum('shock_side',['Left','Right'])->default('Right');
            $table->enum('size_side',['Left','Right'])->default('Right');
            $table->enum('research_side',['Left','Right'])->default('Right');
            $table->enum('websitepage_side',['Left','Right'])->default('Right');
            $table->enum('url_side',['Left','Right'])->default('Right');
            $table->enum('overall_value_side',['Left','Right'])->default('Right');
            $table->string('performance')->nullable();
            $table->string('research_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('exclusive_side','longevity_side','shock_side','size_side','research_side','websitepage_side','url_side','overall_value_side','performance','research_email');
        });
    }
}
