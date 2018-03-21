<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('organization')->nullable();
            $table->integer('org_type')->nullable();
            $table->integer('roll')->unsigned();
            // $table->foreign('roll')->references('id')->on('roll')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('projectname')->unsigned()->nullable();
            // $table->foreign('projectname')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['Enabled', 'Disabled']);
            $table->string('password');
            $table->integer('is_delete');
            $table->integer('is_agree');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
