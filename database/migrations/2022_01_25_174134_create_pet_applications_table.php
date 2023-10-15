<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('family');
            $table->string('species');
            $table->string('size');
            $table->string('weight');
            $table->string('status')->default('pending');
            $table->string('form_status')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('property_id')->nullable();
            $table->integer('apartment_id')->nullable();
            $table->string('mobile')->nullable();
            $table->string('term')->nullable();
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
        Schema::dropIfExists('pet_applications');
    }
}
