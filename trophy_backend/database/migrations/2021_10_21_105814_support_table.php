<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SupportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('reply_id')->nullable();
            $table->string('subject')->nullable();
            $table->text('contents')->nullable();
            $table->text('image')->nullable();
            $table->enum('user_status', array('read', 'unread'))->default('unread');
            $table->enum('admin_status', array('read', 'unread'))->default('unread');
            $table->enum('sender', array('user', 'admin'))->nullable();
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
        Schema::dropIfExists('supports');
    }
}
