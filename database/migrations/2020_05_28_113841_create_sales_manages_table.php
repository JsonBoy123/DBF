<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_manages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("amount_tendered1",111)->nullable();
            $table->string("customer_name",111)->nullable();
            $table->string("sale_amount_due1",111)->nullable();
            $table->string("payment_types",111)->nullable();
            $table->string("selectCashier",11)->nullable();
            $table->string("change_due",111)->nullable();
            $table->string("stock_location",11)->nullable();
            $table->string("ref_invoice_number",111)->nullable();
            $table->string("sgst_cght_sub_total",111)->nullable();
            $table->string("igst_sub_total",111)->nullable();
            $table->string("customer_id",111)->nullable();
            $table->string("employee_id",111)->nullable();
            $table->integer("status")->default("0");
            $table->text("comment")->nullable();
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
        Schema::dropIfExists('sales_manages');
    }
}
