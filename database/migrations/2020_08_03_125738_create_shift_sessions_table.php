<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('session_id')->nullable()->foreign('session_id')->references('id')->on('sessions');
            $table->integer('shift_id')->nullable()->foreign('shift_id')->references('id')->on('shifts');
            $table->integer('day_id')->nullable()->foreign('day_id')->references('id')->on('days');
            $table->enum('is_active',['yes','no'])->default('yes');
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
        Schema::dropIfExists('shift_sessions');
    }
}
