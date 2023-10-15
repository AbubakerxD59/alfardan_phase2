<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_updates', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('outlet')->nullable();
            $table->string('link')->nullable();
            $table->string('submission')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->string('photo')->nullable();
            $table->string('property_id')->nullable();
            $table->string('tenant_type')->nullable();
            $table->string('data_id')->nullable();
            $table->string('whatsapp')->nullable();
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
        Schema::dropIfExists('offer_updates');
    }
}
