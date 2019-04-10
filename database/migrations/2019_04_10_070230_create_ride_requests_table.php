<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRideRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ride_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passenger_id')->unsigned();
            $table->foreign('passenger_id')->references('id')->on('passengers')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('pick_loc_lat',45);
            $table->string('pick_loc_long',45);
            $table->string('dest_loc_lat',45);
            $table->string('dest_loc_long',45);
            $table->timestamp('requested_at');
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
        Schema::dropIfExists('ride_requests');
    }
}
