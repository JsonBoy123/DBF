<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonBenefitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_benefit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('brok_id');  
            $table->integer('item_id');  
            $table->integer('discount_id');  
            $table->decimal('item_discount',15,2);  
            $table->decimal('item_price',15,2);  
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
        Schema::dropIfExists('person_benefit');
    }
}
