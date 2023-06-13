<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('category')->default('0');
            $table->integer('subcategory')->default('0');
            $table->integer('brand')->default('0');
            $table->integer('size')->default('0');
            $table->integer('color')->default('0');
            $table->string('model')->nullable();
            $table->integer('hsn_no')->default('0');
            $table->integer('supplier_id')->nullable();
            $table->string('item_number');
            $table->text('description')->nullable();
            $table->string('price_type')->default('0');
            $table->string('cost_price')->default('0');
            $table->string('unit_price')->default('0');
            $table->string('reorder_level');
            $table->string('receiving_quantity')->default(1);
            $table->string('pic_filename')->nullable();
            $table->string('allow_alt_description')->default('0');
            $table->string('is_serialized')->default('0');
            $table->string('stock_type')->default('0');
            $table->string('item_type')->default('0');
            $table->integer('tax_category_id')->default('1');
            $table->integer('deleted')->default('0');
            $table->string('custom1')->nullable();
            $table->string('custom2')->nullable();
            $table->string('custom3')->nullable();
            $table->string('custom4')->nullable();
            $table->date('custom5')->nullable();
            $table->string('custom6')->nullable();
            $table->string('custom7')->nullable();
            $table->string('custom8')->nullable();
            $table->string('custom9')->nullable();
            $table->string('custom10')->nullable();
            $table->string('column1')->nullable();
            $table->string('column2')->nullable();
            $table->string('column3')->nullable();
            $table->string('column4')->nullable();
            $table->string('column5')->nullable();
            $table->string('column6')->nullable();
            $table->string('column7')->nullable();
            $table->string('column8')->nullable();
            $table->string('column9')->nullable();
            $table->string('column10')->nullable();
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
        Schema::dropIfExists('items');
    }
}
