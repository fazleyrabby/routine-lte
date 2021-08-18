<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutineCommitteeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routine_committee_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_id')->nullable()->foreign('sender_id')->references('id')->on('users');
            $table->integer('receiver_id')->nullable()->foreign('receiver_id')->references('id')->on('users');
            $table->integer('expire_after')->default(2)->nullable();
            $table->dateTime('expired_date');
            $table->enum('request_status', ['expired','active'])->default('active');
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
        Schema::dropIfExists('routine_committee_requests');
    }
}
