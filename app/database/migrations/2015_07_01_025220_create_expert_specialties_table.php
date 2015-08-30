<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertSpecialtiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expert_specialties', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('expert_id')->unsigned();

            $table->string('name', 255);
            $table->text('details');
            $table->string('status', 50);

            $table->foreign('expert_id')->references('id')->on('experts');

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
		Schema::table('expert_specialties', function(Blueprint $table)
		{
			//
		});
	}

}
