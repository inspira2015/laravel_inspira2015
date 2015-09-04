<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyLoadgingTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('api_search_loadging', function(Blueprint $table)
        {
            $table->bigInteger('users_id')->unsigned()->after('leisure_id');
            $table->string('data_type',25)->after('users_id');

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
       

    }
}
