<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToCodesUsedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('codes_used', function(Blueprint $table)
		{
			$table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('codes_id')->references('id')->on('codes')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('codes_used', function(Blueprint $table)
		{
			$table->dropForeign('codes_used_users_id_foreign');
			$table->dropForeign('codes_used_codes_id_foreign');
		});
	}

}
