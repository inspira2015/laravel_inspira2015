<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCodes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('codes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code' , 20);
			$table->date('end_date');
			$table->string('currency',3);
			$table->integer('discover');
			$table->integer('bronze');
			$table->integer('gold');
			$table->integer('platinum');
			$table->integer('diamond');
			$table->integer('points');
			$table->integer('inspira_card');
			$table->integer('vip_card');
			$table->tinyInteger('reuse');
			$table->tinyInteger('used');
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
		Schema::drop('codes');

	}

}
