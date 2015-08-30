<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_documents', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('user_id')->unsigned();

            $table->string('title', 255);
            $table->string('document_name', 255);
            $table->string('document_saved_name', 255);
            $table->string('status', 50);

            $table->foreign('user_id')->references('id')->on('users');

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
		Schema::table('user_documents', function(Blueprint $table)
		{
			//
		});
	}

}
