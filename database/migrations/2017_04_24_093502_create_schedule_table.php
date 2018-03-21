<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_name')->unsigned()->nullable();
            // $table->foreign('project_name')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('client_name')->unsigned()->nullable();
            // $table->foreign('client_name')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('physician_name')->unsigned()->nullable();
            // $table->foreign('physician_name')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('patient_id');
            $table->integer('manufacturer')->unsigned()->nullable();
            // $table->foreign('manufacturer')->references('id')->on('manufacturers')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('device_name')->unsigned()->nullable();
            // $table->foreign('device_name')->references('id')->on('device')->onDelete('cascade');
            $table->string('model_no');
            $table->string('rep_name');
            $table->string('event_date');
            $table->string('start_time');
            $table->enum('status', ['Active', 'Inactive']);            
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
        Schema::dropIfExists('schedule');
    }
}
