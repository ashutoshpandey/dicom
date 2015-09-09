<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');

			$table->integer('institute_id')->unsigned();
            $table->string('username', 255);
            $table->string('user_type', 50);
			$table->string('password', 255);
			$table->string('name', 50);
			$table->string('gender', 10);
			$table->string('email', 255);
			$table->string('contact_number', 50);

            $table->string('status', 50);

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
		Schema::table('users', function(Blueprint $table)
		{
			//
		});
	}

}
