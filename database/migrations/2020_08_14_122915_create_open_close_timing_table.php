<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpenCloseTimingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('open_close_timing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logintime')->nullable();
            $table->string('logouttime')->nullable();
            $table->integer('location_id')->nullable();
            $table->string('location_owner')->nullable();
            $table->string('reason')->nullable();
            $table->string('date')->nullable();
            $table->string('ip')->nullable();
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
        Schema::dropIfExists('open_close_timing');
    }
}
