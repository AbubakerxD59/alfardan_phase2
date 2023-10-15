<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('outlet')->nullable();
            $table->string('phone')->nullable();
            $table->string('link')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('submission')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->text('description')->nullable();
            $table->text('points')->nullable();
            $table->string('photo')->nullable();
            $table->string('property_id')->nullable();
            $table->string('tenant_type')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
            // $table->string('data_id')->nullable();
            // $table->string('link')->nullable();
            // $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
