<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsAffiliationpayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users_affiliations_payments', function($table)
        {
            $table->dropColumn('year');
            $table->dropColumn('month');
            $table->date('charge_at')->after('users_id');
            $table->bigInteger('transaction_id')->nullable()->after('charge_at');
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
        Schema::table('users_affiliations_payments', function($table)
        {
            $table->dropColumn('year');
            $table->dropColumn('month');
            $table->date('charge_at')->after('users_id');
            $table->bigInteger('transaction_id')->nullable()->after('charge_at');
        });
    }
}
