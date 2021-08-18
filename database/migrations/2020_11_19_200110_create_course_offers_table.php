<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_offers', function (Blueprint $table) {
            $table->id();
            $table->integer('batch_id')->nullable()->foreign('batch_id')->references('id')->on('batch');
//          $table->integer('course_id')->nullable()->foreign('course_id')->references('id')->on('courses');
            $table->string('courses', 191)->nullable();
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
        Schema::dropIfExists('course_offers');
    }
}
