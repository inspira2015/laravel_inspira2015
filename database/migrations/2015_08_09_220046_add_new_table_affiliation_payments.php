<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewTableAffiliationPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('users_affiliations_payments', function(Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('users_id')->unsigned();
            $table->integer('affiliations_id')->unsigned();
            $table->string('year' , 4); //2015
            $table->string('month' , 3); //2015
            $table->decimal('amount',8,4);
            $table->string('currency' , 12);
            $table->string('payu_transaction_id' , 120);
            $table->timestamps();
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
        Schema::drop('users_affiliations_payments');

    }
}
