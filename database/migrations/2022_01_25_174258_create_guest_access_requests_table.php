<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestAccessRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_access_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('full_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->date('date');
            $table->time('time');
            $table->string('photo')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('number')->nullable();
            $table->string('form_id')->nullable();
            $table->integer('property_id')->nullable();
            $table->integer('apartment_id')->nullable();
            $table->string('status')->default('pending');
            $table->integer('form_status')->nullable();
            $table->string('reason')->nullable();
            $table->integer('term')->nullable();
            $table->string('term_cond')->nullable();
            $table->date('submission_date')->nullable();
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
        Schema::dropIfExists('guest_access_requests');
    }
}
