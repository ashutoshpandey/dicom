<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstituteSpecialtiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('institute_specialties', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('institute_id')->unsigned();

            $table->string('name', 255);
            $table->text('details');
            $table->string('status', 50);

            $table->foreign('institute_id')->references('id')->on('institutes');

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
		Schema::table('institute_specialties', function(Blueprint $table)
		{
			//
		});
	}

}
