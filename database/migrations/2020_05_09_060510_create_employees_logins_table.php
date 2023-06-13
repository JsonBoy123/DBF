<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_logins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username',111)->nullable();
            $table->string('password',111)->nullable();
            $table->string('emp_id',11)->nullable();
            $table->string('hash_version',111)->nullable();
            $table->string('language',111)->nullable();
            $table->string('language_code',255)->nullable();
            $table->string('login_type',255)->nullable();
            $table->string('inv_prefix',111)->nullable();
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
        Schema::dropIfExists('employees_logins');
    }
}
