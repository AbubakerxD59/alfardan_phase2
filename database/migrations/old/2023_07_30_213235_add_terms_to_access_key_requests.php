<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermsToAccessKeyRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('access_key_requests', function (Blueprint $table) {
            $table->string('form_status')->nullable()->after('status');    
            $table->string('form_id')->nullable()->after('status');    
            $table->string('property_id')->nullable()->after('status');    
            $table->string('apartment_id')->nullable()->after('status');    
            $table->string('photo')->nullable()->after('status');    
            $table->string('submission_date')->nullable()->after('status');    
            $table->string('term_cond')->nullable()->after('status');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('access_key_requests', function (Blueprint $table) {
            //
        });
    }
}
