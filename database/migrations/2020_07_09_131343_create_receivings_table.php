<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('receiving_time');
            $table->unsignedInteger('supplier_id')->nullable();
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('dispatcher_id');
            $table->string('payment_type', 20)->nullable();
            $table->string('reference', 32)->nullable();
            $table->unsignedInteger('destination');
            $table->smallInteger('completed')->default(0);
            $table->text('comment')->nullable();
            $table->text('final_comment')->nullable();
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
        Schema::dropIfExists('receivings');
    }
}
