<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('teacher');
            $table->string('location');
            $table->string('locationdetail');
            $table->text('description');
            $table->unsignedInteger('seats');
            $table->string('tenant_type');
            $table->string('property');
            $table->time('time');
            $table->date('date');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('cover');
            $table->string('term_cond')->nullable();
            $table->integer('status')->nullable();
            $table->integer('news_feed')->nullable();
            $table->integer('total_seats')->nullable();
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
        Schema::dropIfExists('classes');
    }
}
