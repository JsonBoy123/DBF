<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceivingsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivings_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('receiving_id');
            $table->unsignedInteger('item_id');
            $table->string('description')->nullable();
            $table->string('serialnumber')->nullable();
            $table->unsignedInteger('line')->nullable();
            $table->unsignedInteger('quantity_purchased')->default('0');
            $table->decimal('item_cost_price',15,2)->nullable();
            $table->decimal('item_unit_price',15,2)->nullable();
            $table->decimal('discount_percent',15,2)->default('0.00');
            $table->unsignedInteger('item_location')->nullable();
            $table->decimal('receiving_quantity',15,3)->default('1.000');
            
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
        Schema::dropIfExists('receivings_items');
    }
}
