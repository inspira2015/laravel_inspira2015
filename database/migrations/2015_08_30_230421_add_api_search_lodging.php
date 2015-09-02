<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApiSearchLodging extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('api_search_loadging', function(Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->string('leisure_id' , 20);
            $table->string('type',25)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('adult_number')->default(0)->nullable();
            $table->tinyInteger('child_number')->default(0)->nullable();
            $table->decimal('stars',8,2)->nullable();
            $table->string('hotel_name',200)->nullable();
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
        Schema::drop('api_search_loadging');

    }
}
