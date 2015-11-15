<?php

use Illuminate\Database\Seeder;

class ApiSearchLodgingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	DB::table('api_search_lodging')->insert(array(
						array( 'leisure_id' => 'TESTUS02',
							   'type' => 'WEEK',
							   'destiny' => 'MEXICO DF',
                               'start_date' => '2015-12-01',
                               'end_date' => '2015-12-07',
                               'adult_number' => 2,
                               'child_number' => 2,
                               'stars' => 3,
                               'hotel_name' => 'Camino Real',
                               'key_words' => 'Camino Real',

							),
                        array( 'leisure_id' => 'TESTUS03',
                               'type' => 'WEEK',
                               'destiny' => 'LIMA PERU',
                               'start_date' => '2015-12-01',
                               'end_date' => '2015-12-07',
                               'adult_number' => 2,
                               'child_number' => 2,
                               'stars' => 3,
                               'hotel_name' => 'Camino Real',
                               'key_words' => 'Camino Real',

                            ),

		));
    }
}
