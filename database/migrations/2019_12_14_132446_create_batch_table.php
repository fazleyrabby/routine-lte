<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBatchTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('batch', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('batch_no')->nullable()->comment('12,13');
            $table->integer('department_id')->nullable()->foreign('department_id')->references('id')->on('departments');
            $table->integer('shift_id')->nullable()->foreign('shift_id')->references('id')->on('shifts');
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
		Schema::dropIfExists('batch');
	}

}
