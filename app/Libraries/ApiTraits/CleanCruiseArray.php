<?php 
namespace App\Libraries\ApiTraits;


Trait CleanCruiseArray 
{
    public function exchangeArray(array $valid_data)
	{
       
       return array( 
				       'leisure_id'            => (isset($valid_data['leisure_id'])) ? trim($valid_data['leisure_id']) : null,
						'from'        			=> (isset($valid_data['type'])) ? trim($valid_data['type']) : null,
				        'where'           => (isset($valid_data['where'])) ? trim($valid_data['where']) : null,
				        'cruise_line'           => (isset($valid_data['cruise_line'])) ? trim($valid_data['cruise_line']) : null,
				        'cruise_name'           => (isset($valid_data['cruise_name'])) ? trim($valid_data['cruise_name']) : null,
				        'cruise_length'         => (isset($valid_data['cruise_length'])) ? trim($valid_data['cruise_length']) : 0,
				        'start_date'            => (isset($valid_data['start_date'])) ? trim($valid_data['start_date']) : 0,		
						'adult_number'          => (isset($valid_data['adult_number'])) ? trim($valid_data['adult_number']) : null,
					    'child_number'          => (isset($valid_data['child_number'])) ? trim($valid_data['child_number']) : null,
				        'key_words'             => (isset($valid_data['key_words'])) ? trim($valid_data['key_words']) : null,
				        'booking_amount'        => (isset($valid_data['booking_amount'])) ? trim($valid_data['booking_amount']) : null,
					    'booking_date'          => (isset($valid_data['booking_date'])) ? trim($valid_data['booking_date']) : null,
				        'booking_payment_type'  => (isset($valid_data['booking_payment_type'])) ? trim($valid_data['booking_payment_type']) : null,
				    );
	}


	public function lodgingView()
	{
	
	}
   
}