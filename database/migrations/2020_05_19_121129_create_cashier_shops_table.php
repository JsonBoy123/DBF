<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashierShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashier_shops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('shop_id')->default('0');
            $table->integer('cashier_id')->default('0');
            $table->integer('incharge_id')->default('0');
            $table->string('open_time')->nullable();
            $table->string('close_time')->nullable();
            $table->text('address')->nullable();
            $table->text('tnc')->nullable();
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
        Schema::dropIfExists('cashier_shops');
        
    }
}
