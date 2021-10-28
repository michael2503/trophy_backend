<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WebsiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('biz_name')->nullable();
            $table->string('site_name')->nullable();
            $table->string('site_title')->nullable();
            $table->string('site_email')->nullable();
            $table->string('site_description')->nullable();
            $table->string('site_url')->nullable();
            $table->string('favicon_url')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('biz_addr')->nullable();
            $table->string('biz_city')->nullable();
            $table->string('biz_state')->nullable();
            $table->string('biz_country')->nullable();
            $table->string('biz_phone')->nullable();
            $table->string('chat_code')->nullable();
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
        Schema::dropIfExists('website_settings');
    }
}
