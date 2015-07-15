<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyUserVacationalFundLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('vacation_fund_log', function(Blueprint $table)
        {
            $table->string('currency',10)->after('active');

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
         Schema::table('vacation_fund_log', function($table)
        {
            $table->dropColumn('currency');
        });
    }
}
