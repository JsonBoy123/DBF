<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',111);
            $table->string('last_name',111);
            $table->string('gender',15)->nullable();
            $table->string('email',111);
            $table->string('gender',6);
            $table->string('phone_number',15);
            $table->string('address_1',255);
            $table->string('address_2',255);
            $table->string('city',111);
            $table->string('state',111);
            $table->string('postcode',11);
            $table->string('country',111);
            $table->text('comments');
            $table->string('gstin',111);
            $table->string('account_number',111);
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
        Schema::dropIfExists('customers');
    }
}
