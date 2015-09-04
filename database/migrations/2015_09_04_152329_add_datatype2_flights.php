<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatatype2Flights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('api_search_flights', function(Blueprint $table)
        {
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
         Schema::table('api_search_flights', function($table)
        {
            $table->dropColumn('data_type');
        });
    }
}
