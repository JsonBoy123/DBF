<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSheetUploadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sheet_uploade', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sheet_uploader_id');
            $table->char('name',250);
            $table->enum('type', ['new_stock', 'update_stock','undelete_stock']);
            $table->enum('status', ['pending', 'approved','discarded']);
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
        Schema::dropIfExists('sheet_uploade');
    }
}
