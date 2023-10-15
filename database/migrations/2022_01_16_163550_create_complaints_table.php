<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('description');
            $table->string('status')->default('open');
            $table->unsignedInteger('user_id');
            $table->integer('property_id')->nullable();
            $table->integer('apartment_id')->nullable();
            $table->string('form_id')->nullable();
            $table->string('mobile')->nullable();
            $table->integer('form_status')->nullable();
            $table->date('close')->nullable();
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
        Schema::dropIfExists('complaints');
    }
}
