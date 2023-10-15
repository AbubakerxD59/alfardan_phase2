<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('locationdetail')->nullable();
            $table->string('tenant_type')->nullable();
            $table->string('property')->nullable();
            $table->time('time')->nullable();
            $table->date('date')->nullable();
            $table->text('description');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('cover');
            $table->string('term_cond')->nullable();
            $table->integer('status')->nullable();
            $table->time('endtime')->nullable();
            $table->text('avlb_days')->nullable();
            $table->integer('news_feed')->nullable();
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
        Schema::dropIfExists('facilities');
    }
}
