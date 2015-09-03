<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_documents', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('patient_id')->unsigned();

            $table->string('title', 255);
            $table->string('document_name', 255);
            $table->string('document_saved_name', 255);
            $table->string('status', 50);

            $table->foreign('patient_id')->references('id')->on('patients');

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
		Schema::table('patient_documents', function(Blueprint $table)
		{
			//
		});
	}

}
