<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->bigIncrements('trans_id');
            $table->unsignedInteger('trans_items');
            $table->unsignedInteger('trans_user');
            $table->dateTime('trans_date');
            $table->text('trans_comment')->nullable();
            $table->unsignedInteger('trans_location');
            $table->decimal('trans_inventory',15,3)->default('0.000');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory');
    }
}
