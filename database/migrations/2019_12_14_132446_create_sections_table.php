<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sections', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('section_name', 45)->nullable()->comment('A,B,C..etc');
			$table->integer('parent')->default(0);
			$table->string('slug', 45)->nullable();
            $table->enum('type',['theory','lab'])->default('theory');
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
		Schema::dropIfExists('sections');
	}

}
