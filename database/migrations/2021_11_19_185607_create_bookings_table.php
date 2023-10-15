<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('hotel_id')->nullable();
            $table->unsignedInteger('restaurant_id')->nullable();
            $table->unsignedInteger('resort_id')->nullable();
            $table->unsignedInteger('event_id')->nullable();
            $table->unsignedInteger('class_id')->nullable();
            $table->unsignedInteger('facility_id')->nullable();
            $table->unsignedInteger('slot_id')->nullable();
            $table->unsignedInteger('reservations')->nullable();
            $table->time('time')->nullable();
            $table->date('date')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
