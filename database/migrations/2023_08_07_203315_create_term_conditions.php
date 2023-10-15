<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermConditions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('term_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_reg_term')->nullable();
            $table->string('services_term')->nullable();
            $table->string('pet_form_term')->nullable();
            $table->string('maintenance_in_absentia_term')->nullable();
            $table->string('automated_guest_access_term')->nullable();
            $table->string('access_key_card_term')->nullable();
            $table->string('vehicle_form_term')->nullable();
            $table->string('housekeeping_form_term')->nullable();
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
        Schema::dropIfExists('term_conditions');
    }
}
