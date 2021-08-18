<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayWiseSlots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_wise_slots', function (Blueprint $table) {
            $table->id();
            $table->integer('day_id')->nullable()->foreign('day_id')->references('id')->on('days');
            $table->integer('time_slot_id')->nullable()->foreign('time_slot_id')->references('id')->on('time_slots');
            $table->integer('class_slot')->nullable();
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
        Schema::dropIfExists('day_wise_slots');
    }
}
