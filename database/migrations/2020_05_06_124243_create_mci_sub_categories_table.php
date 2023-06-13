<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMciSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mci_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sub_categories_name',255)->nullable();
            $table->string('parent_id',255)->nullable();
            $table->string('alias',255)->nullable();
            $table->string('master_hsn',255)->nullable();
            $table->string('master_tax',255)->nullable();
            $table->string('status',2)->default(0);
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
        Schema::dropIfExists('mci_sub_categories');
    }
}
