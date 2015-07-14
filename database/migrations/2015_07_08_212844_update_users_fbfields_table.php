<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersFbfieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function(Blueprint $table)
        {
            $table->string('facebook_id',150)->nullable();
            $table->string('facebook_link',150)->nullable();
            $table->string('gender',5)->nullable();
            $table->string('facebook_avatar',180)->nullable();

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
        Schema::table('users', function($table)
        {
            $table->dropColumn('facebook_id');
            $table->dropColumn('facebook_link');
            $table->dropColumn('gender');
            $table->dropColumn('facebook_avatar');
        });
    }
}
