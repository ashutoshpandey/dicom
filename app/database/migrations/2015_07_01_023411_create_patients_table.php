<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patients', function(Blueprint $table)
		{
            $table->increments('id');

            $table->string('name', 255);
            $table->string('gender', 255);
            $table->string('email', 255);
			$table->string('contact_number', 255);
			$table->string('country', 255);
			$table->integer('institute_id')->unsigned();
			$table->string('password', 255);
            $table->string('image_name', 255);
            $table->string('saved_image_name', 255);
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
		Schema::table('patients', function(Blueprint $table)
		{
			//
		});
	}

}
