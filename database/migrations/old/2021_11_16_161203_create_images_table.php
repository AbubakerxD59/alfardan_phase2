<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->unsignedInteger('hotel_id')->nullable();
            $table->unsignedInteger('restaurant_id')->nullable();
            $table->unsignedInteger('resort_id')->nullable();
            $table->unsignedInteger('event_id')->nullable();
            $table->unsignedInteger('class_id')->nullable();
            $table->unsignedInteger('facility_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('maintenance_request_id')->nullable();
            $table->unsignedInteger('maintenance_absentia_request_id')->nullable();
            $table->unsignedInteger('message_id')->nullable();
            $table->unsignedInteger('property_id')->nullable();
            $table->unsignedInteger('apartment_id')->nullable();
            $table->unsignedInteger('family_member_id')->nullable();
            $table->unsignedInteger('employee_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('complaint_id')->nullable();
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
        Schema::dropIfExists('images');
    }
}
