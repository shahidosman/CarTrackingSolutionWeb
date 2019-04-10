<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('request_id');
// One driver's one car can have only one ride active at a time
            $table->boolean('is_active')->default(true);
            $table->string('pick_loc_lat',45);
            $table->string('pick_loc_long',45);
            $table->timestamp('pick_up_at');
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
        Schema::dropIfExists('rides');
    }
}
