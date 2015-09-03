<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('institutes', function(Blueprint $table)
		{
            $table->increments('id');

            $table->string('name', 255);
            $table->dateTime('establish_date');
            $table->string('address', 1000);
			$table->string('land_mark', 255);
			$table->string('contact_number_1', 20);
			$table->string('contact_number_2', 20);
			$table->string('city', 255);
			$table->string('state', 255);
			$table->string('zip', 20);
			$table->string('country', 255);

            $table->float('latitude');
            $table->float('longitude');

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
		Schema::table('institutes', function(Blueprint $table)
		{
			//
		});
	}

}
