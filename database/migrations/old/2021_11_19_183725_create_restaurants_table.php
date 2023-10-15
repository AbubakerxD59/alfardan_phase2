<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('locationdetail');
            $table->text('description');
            $table->string('phone');
            $table->string('date')->nullable();
            $table->string('tenant_type')->nullable();
            $table->string('property')->nullable();
            $table->string('view_link')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('cover')->nullable();
            $table->string('menu1')->nullable();
            $table->string('menu2')->nullable();
            $table->string('menu3')->nullable();
            $table->string('menu4')->nullable();
            $table->string('menu5')->nullable();
            $table->integer('status')->nullable();
            $table->integer('news_feed')->nullable();
            $table->integer('is_privilege')->nullable();
            $table->string('whatsapp')->nullable();
            $table->integer('orders')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('tiktok')->nullable();
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('restaurants');
    }
}
