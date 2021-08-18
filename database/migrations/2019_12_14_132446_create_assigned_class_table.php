<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAssignedClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assigned_class', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('class_no')->nullable();
			$table->bigInteger('schedule_id')->nullable()->foreign('schedule_id')->references('id')->on('class_schedule')->unsigned();
			$table->date('class_date')->nullable();
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
		Schema::dropIfExists('assigned_class');
	}

}
