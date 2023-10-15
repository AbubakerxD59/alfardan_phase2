<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model');
            $table->string('color');
            $table->string('registration');
            $table->string('parking_space');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('form_id')->nullable();
            $table->date('submission_date')->nullable();
            $table->integer('property_id')->nullable();
            $table->integer('apartment_id')->nullable();
            $table->string('phone')->nullable();
            $table->integer('form_status')->nullable();
            $table->string('status')->default('pending');
            $table->string('reason')->nullable();
            $table->string('term_cond')->nullable();
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
        Schema::dropIfExists('vehicle_requests');
    }
}
