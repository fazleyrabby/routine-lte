<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routine', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id')->nullable()->foreign('teacher_id')->references('id')->on('teachers');
            $table->integer('batch_id')->nullable()->foreign('batch_id')->references('id')->on('batch');
            $table->integer('section_id')->nullable()->foreign('section_id')->references('id')->on('sections');
//            $table->integer('day_wise_slot_id')->nullable()->foreign('day_wise_slot_id')->references('id')->on('day_wise_slots');
            $table->integer('day_id')->nullable()->foreign('day_id')->references('id')->on('days');
            $table->integer('time_slot_id')->nullable()->foreign('time_slot_id')->references('id')->on('time_slots');
            $table->integer('course_id')->nullable()->foreign('course_id')->references('id')->on('courses');
            $table->integer('room_id')->nullable()->foreign('room_id')->references('id')->on('rooms');
            $table->integer('created_by')->nullable()->foreign('created_by')->references('id')->on('users');
            $table->integer('edited_by')->nullable()->foreign('edited_by')->references('id')->on('users');
            $table->integer('yearly_session_id')->nullable()->foreign('yearly_session_id')->references('id')->on('yearly_sessions');
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
        Schema::dropIfExists('routine');
    }
}
