<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->date('date');
            $table->time('time');
            $table->string('address');
            $table->string('payment_method');
            $table->string('status')->default('pending');
            $table->integer('form_status')->nullable();
            $table->string('attendee')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('form_id')->nullable();
            $table->integer('property_id')->nullable();
            $table->integer('apartment_id')->nullable();
            $table->date('submission_date')->nullable();
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
        Schema::dropIfExists('service_requests');
    }
}
