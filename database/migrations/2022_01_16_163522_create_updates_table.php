<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('updates', function (Blueprint $table) {
            $table->id();
            $table->string('circular_name')->nullable();
            $table->string('cover');
            $table->text('description');
            $table->integer('property_id')->nullable();
            $table->integer('apartment_id')->nullable();
            $table->integer('circular_id')->nullable();
            $table->string('image')->nullable();
            $table->integer('status')->nullable();
            $table->text('pdffile')->nullable();
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
        Schema::dropIfExists('updates');
    }
}
