<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('job_role')->nullable();
            $table->string('dob')->nullable();
            $table->string('office_number')->nullable();
            $table->string('apartment_id')->nullable();
            $table->string('property_id')->nullable();
            $table->string('type')->nullable();
            $table->string('phone')->nullable();
            $table->string('profile')->nullable();
            $table->integer('status')->nullable();
            $table->string('code')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
