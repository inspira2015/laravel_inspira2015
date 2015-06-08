<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserAffiliations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('user_affiliations', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('inspirausers_id');
			$table->integer('affiliations_id');
			$table->tinyInteger('active');
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
		Schema::drop('user_affiliations');

	}

}
