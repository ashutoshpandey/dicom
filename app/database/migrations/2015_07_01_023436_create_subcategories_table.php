<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sub_categories', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('category_id')->unsigned();
            $table->string('name', 255);
            $table->string('status', 50);

            $table->foreign('category_id')->references('id')->on('categories');

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
		Schema::table('sub_categories', function(Blueprint $table)
		{
			//
		});
	}

}
