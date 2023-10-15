<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->time('time')->nullable();
            $table->string('tenant_type')->nullable();
            $table->string('property')->nullable();
            $table->integer('status')->nullable();
            $table->integer('news_feed')->nullable();
            $table->string('location');
            $table->string('locationdetail')->nullable();
            $table->text('description');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('cover');
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
        Schema::dropIfExists('events');
    }
}
