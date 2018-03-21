<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFlagSurveyAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_answer', function (Blueprint $table) {
          
            $table->enum('flag', ['True', 'False'])->default('False');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('survey_answer',function(Blueprint $table){
            $table->dropColumn('deviceId');
        });
    }
}
