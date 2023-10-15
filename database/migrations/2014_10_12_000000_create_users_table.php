<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->unique()->nullable();
            $table->string('telephone')->unique()->nullable();
            $table->string('dob')->nullable();
            $table->string('type')->nullable();
            $table->string('property')->nullable();
            $table->string('apt_number')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_guest')->default(0);
            $table->integer('status')->nullable();
            $table->string('reject_reason')->nullable();
            $table->string('tenant_type')->nullable();
            $table->string('nom')->nullable();
            $table->string('start_date')->nullable();
            $table->string('company_name')->nullable();
            $table->string('original_tenant_name')->nullable();
            $table->string('submit_date')->nullable();
            $table->string('fusername')->nullable();
            $table->string('name')->nullable();
            $table->string('registered_as')->nullable();
            $table->string('refrence_id')->nullable();
            $table->string('contract')->nullable();
            $table->string('end_date')->nullable();
            $table->string('message')->nullable();
            $table->string('profile')->nullable();
            $table->string('device_token')->nullable();
            $table->string('email_ver_code')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
