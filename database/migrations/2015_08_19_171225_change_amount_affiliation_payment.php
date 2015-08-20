<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAmountAffiliationPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('users_affiliations_payments', function(Blueprint $table)
        {
            $table->dropColumn('amount');
            
        });

        Schema::table('users_affiliations_payments', function(Blueprint $table)
        {
           $table->decimal('amount',18,4)->nullable()->after('affiliations_id');
           
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
