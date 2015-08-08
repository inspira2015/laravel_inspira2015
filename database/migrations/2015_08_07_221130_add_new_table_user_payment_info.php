<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewTableUserPaymentInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('users_payment_info', function(Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('users_id')->unsigned();
            $table->string('token' , 120);
            $table->string('name_on_card' , 60);
            $table->string('payment_method' , 60);
            $table->string('address' , 180);
            $table->string('address2' , 180);
            $table->string('city' , 50);
            $table->string('state' , 50);
            $table->string('zip_code' , 20);
            $table->string('country' , 50);
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
        Schema::drop('users_payment_info');

    }
}
