<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewTableAffiliationDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('affiliations_description', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('affiliations_id');
            $table->mediumText('description_es');
            $table->mediumText('description_en');
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
        Schema::drop('affiliations_description');

    }
}
