<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamic_pricings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("title");
            $table->integer("location")->default("0");
            $table->integer("pointer")->default("0");
            $table->datetime("start_date");
            $table->datetime("end_date");
            $table->float("discount", 8, 2);
            $table->integer("status")->default("0");
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
        Schema::dropIfExists('dynamic_pricings');
    }
}
