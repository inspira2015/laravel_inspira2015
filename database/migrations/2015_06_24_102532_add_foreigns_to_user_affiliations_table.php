<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToUserAffiliationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_affiliations', function(Blueprint $table)
		{
			$table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('affiliations_id')->references('id')->on('affiliations')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_affiliations', function(Blueprint $table)
		{
			$table->dropForeign('users_affiliations_users_id_foreign');
			$table->dropForeign('users_affiliations_affiliations_id_foreign');
		});
	}

}
