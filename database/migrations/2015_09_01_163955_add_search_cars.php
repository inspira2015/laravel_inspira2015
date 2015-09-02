<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSearchCars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('api_search_cars', function(Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->string('leisure_id' , 20);
            $table->bigInteger('users_id')->unsigned();
            $table->string('from',150)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->string('where',150)->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('car_type',75)->nullable();
            $table->string('payment_type',50)->nullable();
            $table->text('key_words')->nullable();
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
        Schema::drop('api_search_cars');

    }
}
