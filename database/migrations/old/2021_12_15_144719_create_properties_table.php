<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('locationdetail');
            $table->text('description');
            $table->string('phone');
            $table->string('email');
            $table->text('residences');
            $table->text('facilities');
            $table->text('services');
            $table->text('privileges');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('cover');
            $table->string('short_description')->nullable();
            $table->string('view_link')->nullable();
            $table->string('view_link_1')->nullable();
            $table->string('view_link_2')->nullable();
            $table->string('view_link_3')->nullable();
            $table->string('view_link_4')->nullable();
            $table->string('handbook')->nullable();
            $table->string('brochure')->nullable();
            $table->string('safety_handbook')->nullable();
            $table->string('safety')->nullable();
            $table->string('status')->nullable();
            $table->string('cpnumber')->nullable();
            $table->string('whatsapp')->nullable();
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
        Schema::dropIfExists('properties');
    }
}
