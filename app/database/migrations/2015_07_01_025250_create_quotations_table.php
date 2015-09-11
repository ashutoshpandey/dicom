<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotations', function(Blueprint $table)
		{
            $table->increments('id');

			$table->integer('request_id')->unsigned();
            $table->string('kind_attention', 255);
            $table->string('dated', 50);
			$table->string('file_number', 50);
			$table->string('hostpial_reference', 255);
			$table->string('patient_age', 5);
			$table->string('sex', 10);
			$table->string('nationality', 50);
			$table->string('medical_speciality', 50);
			$table->string('referring_party', 255);
			$table->string('treating_doctor', 255);

			$table->string('treatment_protocols', 1000);

			$table->string('pre_evaluation_prescribed', 10);
			$table->string('pre_evaluation_cost', 10);
			$table->string('pre_evolution_duration', 10);
			$table->string('surgery1_prescribed', 10);
			$table->string('surgery1_cost', 10);
			$table->string('surgery1_duration', 10);
			$table->string('surgery2_prescribed', 10);
			$table->string('surgery2_cost', 10);
			$table->string('surgery2_duration', 10);
			$table->string('followup_post_discharge_prescribed', 10);
			$table->string('followup_post_discharge_cost', 10);
			$table->string('followup_post_discharge_duration', 10);
			$table->string('total_prescribed', 10);
			$table->string('total_cost', 10);
			$table->string('total_duration', 10);

			$table->string('clinical_success_rate', 50);
			$table->string('length_of_stay', 20);

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
