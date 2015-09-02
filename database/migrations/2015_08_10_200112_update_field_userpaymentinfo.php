<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldUserpaymentinfo extends Migration
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
            $table->bigInteger('transaction_id')->nullable()->after('users_id');

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
            $table->dropColumn('transaction_id');
        });
    }
}
