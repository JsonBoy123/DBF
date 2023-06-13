<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->date('sale_time');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('employee_id');            
            $table->integer('cashier_id');
            $table->text('comment')->nullable();
            $table->char('invoice_number',255)->nullable();
            $table->integer('tally_number')->nullable();
            $table->char('quote_number',255)->nullable();
            $table->char('bill_type',255)->nullable();
            $table->tinyInteger('sale_status')->nullable();
            $table->tinyInteger('sale_type')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('employee_id')->references('id')->on('shops');
            $table->timestamps();
        });

        Schema::create('sales_items', function (Blueprint $table) {
            // $table->id();
            $table->unsignedInteger('sale_id');
            $table->unsignedInteger('item_id');            
            $table->unsignedInteger('item_location');    
            $table->unsignedInteger('category_id');        
            $table->text('description')->nullable();
            $table->integer('line')->nullable();           
            $table->integer('taxe_rate')->nullable();           
            $table->decimal('quantity_purchased',15,2)->nullable();           
            $table->decimal('item_cost_price',15,2)->nullable();           
            $table->decimal('item_unit_price',15,2)->nullable();           
            $table->decimal('discount_percent',15,2)->nullable();           
            $table->tinyInteger('print_option')->nullable();           
            $table->foreign('item_location')->references('id')->on('shops');
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->foreign('item_id')->references('id')->on('items');            
            $table->foreign('category_id')->references('id')->on('mci_categories');
            $table->timestamps();
        });

        Schema::create('sales_items_taxes', function (Blueprint $table) {
            // $table->id();
            $table->unsignedInteger('sale_id');
            $table->unsignedInteger('item_id');                  
            $table->integer('line')->nullable();           
            $table->char('name',50)->nullable();                       
            $table->decimal('percent',15,2)->nullable();                                 
            $table->tinyInteger('tax_type')->nullable();                           
            $table->tinyInteger('rounding_code')->nullable();                           
            $table->tinyInteger('cascade_tax')->nullable();                           
            $table->tinyInteger('cascade_sequence')->nullable();                        
            $table->decimal('item_tax_amount')->nullable();                        
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->foreign('item_id')->references('id')->on('items');
            $table->timestamps();
        });

        Schema::create('sales_payments', function (Blueprint $table) {
            // $table->id();
            $table->unsignedInteger('sale_id');
            $table->char('payment_type',40);                  
            $table->decimal('payment_amount',15,2)->nullable(); 
            $table->foreign('sale_id')->references('id')->on('sales');              
            $table->timestamps();
        });

        Schema::create('sales_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sale_id');
            $table->tinyInteger('tax_type')->nullable();                           
            $table->char('tax_group')->nullable();
            $table->decimal('sale_tax_basis',15,4);
            $table->decimal('sale_tax_amount',15,4);
            $table->tinyInteger('print_sequence');
            $table->char('name',255);            
            $table->decimal('tax_rate',15,4);
            $table->char('sales_tax_code',255)->nullable();
            $table->tinyInteger('rounding_code')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
