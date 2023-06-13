<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageItemByRackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_rack', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rack_number');
            $table->timestamps();
        });

        Schema::create('manage_item_by_rack', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('rack_id');
            $table->unsignedInteger('item_id');
            $table->foreign('rack_id')->references('id')->on('item_rack');
            $table->foreign('item_id')->references('id')->on('items');
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
        Schema::dropIfExists('manage_item_by_rack');
    }
}
