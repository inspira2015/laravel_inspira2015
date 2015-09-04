<?php 
namespace App\Libraries\ApiTraits;


trait CleanFlightArray 
{
    public function exchangeArray(array $valid_data)
	{
       
       return array( 
				       'leisure_id'             => (isset($valid_data['leisure_id'])) ? trim($valid_data['leisure_id']) : null,
						'from'        			=> (isset($valid_data['from'])) ? trim($valid_data['from']) : null,
				        'where'                 => (isset($valid_data['where'])) ? trim($valid_data['where']) : null,
				        'type'            		=> (isset($valid_data['type'])) ? trim($valid_data['type']) : null,
				        'start_date'            => (isset($valid_data['start_date'])) ? trim($valid_data['start_date']) : null,
				       	'end_date'              => (isset($valid_data['end_date'])) ? trim($valid_data['end_date']) : null,
				        'adult_number'          => (isset($valid_data['adult_number'])) ? trim($valid_data['adult_number']) : 0,
				        'child_number'          => (isset($valid_data['child_number'])) ? trim($valid_data['child_number']) : 0,		
						'air_line'            	=> (isset($valid_data['air_line'])) ? trim($valid_data['air_line']) : null,
					    'airfare'            	=> (isset($valid_data['airfare'])) ? trim($valid_data['airfare']) : null,
				        'key_words'             => (isset($valid_data['key_words'])) ? trim($valid_data['key_words']) : null,
				    );
	}
   
}