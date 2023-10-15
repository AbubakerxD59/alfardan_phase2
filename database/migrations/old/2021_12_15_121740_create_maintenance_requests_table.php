<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('type');
            $table->integer('property_id');
            $table->integer('apartment_id');
            $table->text('description');
            $table->dateTime('datetime');
            $table->date('date');
            $table->time('time');
            $table->string('status')->default('open');
            $table->string('tenant_type')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('emp_name')->nullable();
            $table->string('ticket_id')->nullable();
            $table->integer('form_status')->nullable();
            $table->date('complaintclosedate')->nullable();
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
        Schema::dropIfExists('maintenance_requests');
    }
}
