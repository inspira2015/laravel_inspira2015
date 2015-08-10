<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewTableTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::create('system_transactions', function(Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('users_id')->unsigned()->nullable();
            $table->string('code' , 12); //2015
            $table->string('type' , 250); //2015
            $table->text('description' , 250); //2015
            $table->decimal('amount',8,4)->nullable();
            $table->string('currency' , 12)->nullable();
            $table->string('payu_transaction_id' , 120)->nullable();
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
        Schema::drop('system_transactions');

    }
}
