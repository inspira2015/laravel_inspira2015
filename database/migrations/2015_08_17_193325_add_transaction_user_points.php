<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionUserPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users_points', function(Blueprint $table)
        {
            $table->bigInteger('transaction_id')->nullable()->after('users_id');
            $table->decimal('balance',8,4)->nullable()->after('substracted_points');
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
         Schema::table('users_points', function($table)
        {
            $table->dropColumn('transaction_id');
            $table->dropColumn('balance');

        });
    }
}
