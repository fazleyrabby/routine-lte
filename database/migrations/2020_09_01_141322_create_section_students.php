<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_students', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->nullable()->foreign('student_id')->references('id')->on('students');
            $table->integer('section_id')->nullable()->foreign('section_id')->references('id')->on('sections');
            $table->enum('section_type',['lab','theory'])->nullable();
            $table->enum('is_active',['yes','no'])->default('yes');
            $table->integer('students')->nullable();
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
        Schema::dropIfExists('section_students');
    }
}
