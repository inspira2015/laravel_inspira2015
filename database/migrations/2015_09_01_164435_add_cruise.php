<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCruise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('api_search_cruise', function(Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->string('leisure_id' , 20);
            $table->bigInteger('users_id')->unsigned();
            $table->string('from',150)->nullable();
            $table->string('where',150)->nullable();
            $table->string('cruise_line',150)->nullable();
            $table->string('cruise_name',150)->nullable();
            $table->decimal('cruise_lenght',8,2)->nullable();
            $table->tinyInteger('adult_number')->default(0)->nullable();
            $table->tinyInteger('child_number')->default(0)->nullable();
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
        Schema::drop('api_search_cruise');

    }
}
