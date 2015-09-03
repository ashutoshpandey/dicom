<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_request_forwards', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('patient_id')->unsigned();
			$table->integer('connection_id')->unsigned();
			$table->integer('institute_id')->unsigned();
			$table->integer('expert_id')->unsigned();
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
		Schema::table('patient_request_forwards', function(Blueprint $table)
		{
			//
		});
	}

}
