<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("company_name",111)->nullable();
            $table->string("company_logo",111)->nullable();
            $table->string("address",111)->nullable();
            $table->string("website",111)->nullable();
            $table->string("email",111)->nullable();
            $table->string("phone",111)->nullable();
            $table->string("fax",111)->nullable();
            $table->string("return_policy",111)->nullable();
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
        Schema::dropIfExists('configurations');
    }
}
