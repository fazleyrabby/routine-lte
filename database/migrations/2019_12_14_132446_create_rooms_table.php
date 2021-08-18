<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoomsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rooms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('building', 45)->nullable();
			$table->string('room_no', 45)->nullable();
			$table->integer('capacity')->nullable();
            $table->enum('room_type',['0', '1'])->comment('0=Theory,1=Lab');
            $table->timestamps();
            $table->enum('is_active',['yes','no'])->default('yes');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('rooms');
	}

}
