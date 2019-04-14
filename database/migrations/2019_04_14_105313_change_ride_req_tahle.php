<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRideReqTahle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ride_requests',function ($table){
            $table->string('pick_loc_address')->after('passenger_id')->nullable();
            $table->string('status')->after('requested_at')->nullable();
            $table->string('request_mode')->after('status')->nullable();
            $table->string('dest_loc_address')->after('pick_loc_long')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ride_requests',function ($table){
            $table->dropColumn('pick_loc_address');
            $table->dropColumn('status');
            $table->dropColumn('request_mode');
            $table->dropColumn('dest_loc_address');
        });
    }
}
