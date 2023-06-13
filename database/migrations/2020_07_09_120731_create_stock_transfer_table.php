<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('receiving_id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('accept');
            $table->unsignedInteger('good')->nullable();
            $table->unsignedInteger('bad')->nullable();
            $table->unsignedInteger('scrap')->nullable();
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
        Schema::dropIfExists('stock_transfer');
    }
}
