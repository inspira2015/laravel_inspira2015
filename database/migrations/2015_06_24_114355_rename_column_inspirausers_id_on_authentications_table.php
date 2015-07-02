<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnInspirausersIdOnAuthenticationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('authentications', function(Blueprint $table)
		{
			$table->dropColumn('inspirausers_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('authentications', function(Blueprint $table)
		{
			$table->bigInteger('inspirausers_id');
		});
	}

}
