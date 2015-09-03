<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstituteConnectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('institute_connections', function(Blueprint $table)
		{
            $table->increments('id');

			$table->integer('institute_id')->unsigned();
			$table->integer('connection_id')->unsigned();

			$table->string('status', 50);

			$table->foreign('institute_id')->references('id')->on('institutes');
			$table->foreign('connection_id')->references('id')->on('institutes');

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
		Schema::table('institute_connections', function(Blueprint $table)
		{
			//
		});
	}

}
