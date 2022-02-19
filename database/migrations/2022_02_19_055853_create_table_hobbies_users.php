<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHobbiesUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hobbies_user', function (Blueprint $table) {
            $table->id();

            //Add Foreign Key With Hobbies Table
            $table->bigInteger('hobbies_id')->unsigned();
            $table->foreign('hobbies_id')->references('id')->on('hobbies')->onDelete('cascade');

            //Add Foreign Key With Users Table
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('hobbies_user');
    }
}
