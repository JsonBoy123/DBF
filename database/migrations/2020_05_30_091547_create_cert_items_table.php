<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cert_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("item_number",111)->nullable();
            $table->string("name",111)->nullable();
            $table->string("quantity",111)->nullable();
            $table->string("unit_price",111)->nullable();
            $table->string("item_id",111)->nullable();
            $table->string("customer_id",111)->nullable();
            $table->integer("status")->default("0");
            $table->softDeletes();
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
        Schema::dropIfExists('cert_items');
    }
}
