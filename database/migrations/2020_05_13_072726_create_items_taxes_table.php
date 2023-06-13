<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('item_id')->default('0');
            $table->string('CGST');
            $table->string('SGST');
            $table->string('IGST');
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
        Schema::dropIfExists('items_taxes');
    }
}
