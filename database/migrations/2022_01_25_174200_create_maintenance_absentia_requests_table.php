<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceAbsentiaRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_absentia_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('property');
            $table->date('date');
            $table->time('time');
            $table->text('description');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('form_id')->nullable();
            $table->integer('property_id')->nullable();
            $table->integer('apartment_id')->nullable();
            $table->date('submission_date')->nullable();
            $table->string('status')->default('pending');
            $table->integer('form_status')->nullable();
            $table->integer('term')->nullable();
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
        Schema::dropIfExists('maintenance_absentia_requests');
    }
}
