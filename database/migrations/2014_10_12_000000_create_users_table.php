<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->startFrom(1001);
            $table->string('employee_id')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('password');
            $table->string('plan')->nullable();
            $table->integer('parent_id')->default(0)->comment('id is parent_id');
            $table->integer('is_active')->default(0)->comment("0:inactive,1:active");
            $table->integer('status')->default(0)->comment("0:inactive,1:active");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
