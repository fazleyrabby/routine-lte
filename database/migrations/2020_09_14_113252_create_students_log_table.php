<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_log', function (Blueprint $table) {
            $table->id();
            $table->integer('number_of_student');
            $table->integer('batch_id')->nullable()->foreign('batch_id')->references('id')->on('batches');
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
        Schema::dropIfExists('students_log');
    }
}
