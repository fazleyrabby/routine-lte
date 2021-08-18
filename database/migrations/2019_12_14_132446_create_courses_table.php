<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courses', function(Blueprint $table)
		{
		$table->increments('id');
		$table->string('course_name', 191)->nullable();
		$table->string('credit', 191)->nullable();
		$table->string('course_code', 45)->unique()->comment('CSE 222, CEN 431 ..etc');
		$table->timestamps();
		$table->enum('is_active',['yes','no'])->default('yes');
		$table->enum('course_type',['0', '1'])->comment('0=Theory,1=Sessional');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('courses');
	}

}
