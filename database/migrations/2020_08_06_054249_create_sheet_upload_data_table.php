<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSheetUploadDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sheet_upload_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sheet_id');
            $table->enum('status', ['new_stock', 'stock_up','discarded']);
            $table->char('barcode',50);
            $table->char('name',100);
            $table->char('hsn',10);
            $table->char('category',100);
            $table->char('subcategory',100);
            $table->char('brand',100);
            $table->decimal('price',15,2);
            $table->decimal('IGST',15,2);
            $table->decimal('retail_discount',15,2);
            $table->decimal('wholesale_discount',15,2);
            $table->decimal('franchise_discount',15,2);
            $table->decimal('ys_discount',15,2);
            $table->decimal('retail_fp',15,2);
            $table->decimal('wholesale_fp',15,2);
            $table->decimal('damaged_fp',15,2);
            $table->timestamp('expiry_date');
            $table->char('stock_edition',100);
            $table->char('model',100);
            $table->char('color',100);
            $table->char('size',100);
            $table->text('item_description',100);
            $table->integer('reorder_level');
            $table->integer('shop_id');
            $table->integer('location_qty');
            $table->text('column1');
            $table->text('column2');
            $table->text('column3');
            $table->text('column4');
            $table->text('column5');
            $table->text('column6');
            $table->text('column7');
            $table->text('column8');
            $table->text('column9');
            $table->text('column10');
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
        Schema::dropIfExists('sheet_upload_data');
    }
}
