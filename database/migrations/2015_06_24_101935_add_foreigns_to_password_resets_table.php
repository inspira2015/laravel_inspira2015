<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToPasswordResetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('password_resets', function(Blueprint $table)
		{
			$table->foreign('email')->references('email')->on('users')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('password_resets', function(Blueprint $table)
		{
			$table->dropForeign('password_resets_email_foreign');
		});
	}

}
