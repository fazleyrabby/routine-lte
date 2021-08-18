<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigIncrements('id');
            $table->string('key')->nullable();
            $table->string('firstname', 191)->nullable();
            $table->string('lastname', 191)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('username', 191)->unique();
            $table->boolean('gender')->nullable()->comment('1=male,2=female');
            $table->string('email', 191)->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password', 191)->nullable();
            $table->enum('role', array('superadmin','admin','subadmin','user'))->default('user');
            $table->enum('is_active',['yes','no'])->default('yes');
            $table->enum('is_teacher',['yes','no'])->default('yes');
            $table->enum('in_committee',['yes','no'])->default('no');
            $table->string('remember_token', 191)->nullable();
            $table->string('photo', 191)->nullable();
            $table->string('contact')->nullable();
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
		Schema::dropIfExists('users');
	}

}
