<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientRequestForwardRepliesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_request_forward_replies', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('request_id')->unsigned();
			$table->integer('request_forward_id')->unsigned();
			$table->integer('expert_id')->unsigned();
			$table->string('comment', 255);
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
		Schema::table('patient_request_forward_replies', function(Blueprint $table)
		{
			//
		});
	}

}
