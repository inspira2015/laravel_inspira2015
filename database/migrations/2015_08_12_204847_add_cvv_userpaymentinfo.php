<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCvvUserpaymentinfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('users_payment_info', function(Blueprint $table)
        {
            $table->string('ccv',8)->nullable()->after('token');

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
         Schema::table('users_payment_info', function($table)
        {
            $table->dropColumn('ccv');
        });

    }
}
