<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('locationdetail')->nullable();
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->string('tenant_type')->nullable();
            $table->string('property')->nullable();
            $table->string('view_link')->nullable();
            $table->string('phone');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('cover');
            $table->integer('status')->nullable();
            $table->string('news_feed')->nullable();
            $table->integer('is_privilege')->nullable();
            $table->string('whatsapp')->nullable();
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
        Schema::dropIfExists('hotels');
    }
}
