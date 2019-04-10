<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompleteRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complete_rides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ride_id')->unsigned();
            $table->foreign('ride_id')->references('id')->on('rides')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('drop_loc_lat',45);
            $table->string('drop_loc_long',45);
            $table->decimal('total_distance');
            $table->time('total_time');
            $table->decimal('price');
            $table->timestamps();
            //Please mark is_active = false in ride table by ride id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complete_rides');
    }
}
