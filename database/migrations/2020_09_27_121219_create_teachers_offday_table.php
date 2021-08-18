<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersOffdayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers_offday', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id')->nullable()->foreign('teacher_id')->references('id')->on('teachers');
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
        Schema::dropIfExists('teachers_offday');
    }
}
