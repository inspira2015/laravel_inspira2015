<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAffiliations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('affiliations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name_es' , 20);
			$table->string('name_eng',20);
			$table->string('small_desc_es',200);
			$table->string('small_desc_eng',200);
			$table->integer('tier_id');
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
		//
		Schema::drop('affiliations');

	}

}
