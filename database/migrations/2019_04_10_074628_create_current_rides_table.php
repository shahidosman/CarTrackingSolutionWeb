<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_rides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ride_id')->unsigned();
            $table->foreign('ride_id')->references('id')->
            on('rides')->onUpdate('cascade')->onDelete('cascade');
            $table->string('curr_loc_lat',45);
            $table->string('curr_loc_long',45);
            $table->decimal('elapsed_dist');
            $table->time('elapsed_time');
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
        Schema::dropIfExists('current_rides');
    }
}
