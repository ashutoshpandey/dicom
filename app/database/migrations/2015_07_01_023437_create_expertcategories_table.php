<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expert_categories', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('category_id')->unsigned();
			$table->integer('subcategory_id')->unsigned();
			$table->integer('expert_id')->unsigned();

            $table->string('status', 50);

            $table->foreign('category_id')->references('id')->on('categories');
//			$table->foreign('subcategory_id')->references('id')->on('sub_categories');
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
		Schema::table('expert_categories', function(Blueprint $table)
		{
			//
		});
	}

}
