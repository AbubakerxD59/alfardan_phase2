<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('property_id')->nullable();
            $table->integer('floor_id')->nullable();
            $table->integer('tower_id')->nullable();
            $table->integer('apartment_id')->nullable();
            $table->integer('complaint_id')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('title')->nullable();
            $table->string('message')->nullable();
            $table->integer('serivec_id')->nullable();
            $table->integer('pet_id')->nullable();
            $table->integer('maintenance_absentia_id')->nullable();
            $table->integer('guest_id')->nullable();
            $table->integer('access_id')->nullable();
            $table->integer('vehicle_id')->nullable();
            $table->integer('housekeeper_id')->nullable();
            $table->integer('maintenance_id')->nullable();
            $table->integer('is_read')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
