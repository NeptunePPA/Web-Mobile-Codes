<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SurveyAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_answer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('surveyId')->unsigned()->nullable();
            $table->foreign('surveyId')->references('id')->on('survey')->onDelete('cascade')->onUpdate('cascade');
            $table->string('que_1')->nullable();
            $table->enum('que_1_check', ['True', 'False'])->default('False');
            $table->enum('que_1_answer', ['True', 'False'])->default('False');
            $table->string('que_2')->nullable();
            $table->enum('que_2_check', ['True', 'False'])->default('False');
            $table->enum('que_2_answer', ['True', 'False'])->default('False');
            $table->string('que_3')->nullable();
            $table->enum('que_3_check', ['True', 'False'])->default('False');
            $table->enum('que_3_answer', ['True', 'False'])->default('False');
            $table->string('que_4')->nullable();
            $table->enum('que_4_check', ['True', 'False'])->default('False');
            $table->enum('que_4_answer', ['True', 'False'])->default('False');
            $table->string('que_5')->nullable();
            $table->enum('que_5_check', ['True', 'False'])->default('False');
            $table->enum('que_5_answer', ['True', 'False'])->default('False');
            $table->string('que_6')->nullable();
            $table->enum('que_6_check', ['True', 'False'])->default('False');
            $table->enum('que_6_answer', ['True', 'False'])->default('False');
            $table->string('que_7')->nullable();
            $table->enum('que_7_check', ['True', 'False'])->default('False');
            $table->enum('que_7_answer', ['True', 'False'])->default('False');
            $table->string('que_8')->nullable();
            $table->enum('que_8_check', ['True', 'False'])->default('False');
            $table->enum('que_8_answer', ['True', 'False'])->default('False');
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
        Schema::dropIfExists('survey_answer');
    }
}
