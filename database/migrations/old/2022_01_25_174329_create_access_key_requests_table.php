<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessKeyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_key_requests', function (Blueprint $table) {
            $table->id();
            $table->string('card_type');
            $table->string('reason');
            $table->string('location');
            $table->string('phone');
            $table->string('access_type');
            $table->date('expiry_date');
            $table->string('quantity');
            $table->string('charge');
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('status')->default('pending');
            $table->string('form_status')->nullable();
            $table->string('employee')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('form_id')->nullable();
            $table->integer('property_id')->nullable();
            $table->integer('apartment_id')->nullable();
            $table->string('photo')->nullable();
            $table->date('submission_date')->nullable();
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
        Schema::dropIfExists('access_key_requests');
    }
}
