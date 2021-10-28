<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('password')->nullable();
            $table->text('api_token')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('interest')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('photo')->nullable();
            $table->integer('email_verify')->default(0);
            $table->integer('phone_verify')->default(0);
            $table->enum('status', array('Pending', 'Active', 'Suspended', 'Blocked'))->default('Active');
            $table->string('signup_ip')->nullable();
            $table->dateTime('signup_date')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->dateTime('last_login')->nullable();
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
