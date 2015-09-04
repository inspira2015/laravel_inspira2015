<?php 
namespace App\Libraries\ApiTraits;


trait CleanLoadgingArray 
{
    public function exchangeArray(array $valid_data)
	{
       
       return array( 
				       'leisure_id'            => (isset($valid_data['leisure_id'])) ? trim($valid_data['leisure_id']) : null,
						'type'        			=> (isset($valid_data['type'])) ? trim($valid_data['type']) : null,
				        'destiny'               => (isset($valid_data['destiny'])) ? trim($valid_data['destiny']) : null,
				        'start_date'            => (isset($valid_data['start_date'])) ? trim($valid_data['start_date']) : null,
				        'end_date'              => (isset($valid_data['end_date'])) ? trim($valid_data['end_date']) : null,
				        'adult_number'          => (isset($valid_data['adult_number'])) ? trim($valid_data['adult_number']) : 0,
				        'child_number'          => (isset($valid_data['child_number'])) ? trim($valid_data['child_number']) : 0,		
						'stars'            	    => (isset($valid_data['stars'])) ? trim($valid_data['stars']) : null,
					    'hotel_name'            => (isset($valid_data['hotel_name'])) ? trim($valid_data['hotel_name']) : null,
				        'key_words'             => (isset($valid_data['key_words'])) ? trim($valid_data['key_words']) : null,
				    );
	}
   
}