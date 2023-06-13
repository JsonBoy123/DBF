<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',111)->nullable();
            $table->string('last_name',111)->nullable();
            $table->string('gender',11)->nullable();
            $table->string('email',111)->nullable();
            $table->string('phone_number',15)->nullable();
            $table->string('address_1',255)->nullable();
            $table->string('address_2',255)->nullable();
            $table->string('city',111)->nullable();
            $table->string('state',111)->nullable();
            $table->string('postcode',11)->nullable();
            $table->string('country',111)->nullable();
            $table->text('comments')->nullable();
            $table->string('status',2)->default(0);
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
        });

         Schema::create('shops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->unsignedInteger('shop_owner_id');
            $table->text('address')->nullable();
            $table->string('alias')->nullable();
            $table->string('inv_prefix')->nullable();
            $table->text('tnc')->nullable();
            $table->foreign('shop_owner_id')->references('id')->on('employees');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('shops');
    }
}
