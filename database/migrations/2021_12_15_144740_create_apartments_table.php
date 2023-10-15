<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('title');
            $table->string('location');
            $table->string('bedrooms');
            $table->string('bathrooms');
            $table->text('area');
            $table->string('view_link');
            $table->text('description');
            $table->string('phone');
            $table->string('email');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('cover');
            $table->string('status');
            $table->string('availability');
            $table->unsignedInteger('property_id')->nullable();
            $table->unsignedInteger('tower_id')->nullable();
            $table->unsignedInteger('floor_id')->nullable();
            $table->text('short_description');
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
        Schema::dropIfExists('apartments');
    }
}
