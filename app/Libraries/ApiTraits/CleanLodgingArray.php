<?php 
namespace App\Libraries\ApiTraits;


Trait CleanLodgingArray 
{
    public function exchangeArray(array $valid_data)
	{
       
       return array( 
				       'leisure_id'            => (isset($valid_data['leisure_id'])) ? trim($valid_data['leisure_id']) : null,
						'type'        			=> (isset($valid_data['type'])) ? trim($valid_data['type']) : null,
				        'destination'               => (isset($valid_data['destination'])) ? trim($valid_data['destination']) : null,
				        'start_date'            => (isset($valid_data['start_date'])) ? trim($valid_data['start_date']) : null,
				        'end_date'              => (isset($valid_data['end_date'])) ? trim($valid_data['end_date']) : null,
				        'adult_number'          => (isset($valid_data['adult_number'])) ? trim($valid_data['adult_number']) : 0,
				        'child_number'          => (isset($valid_data['child_number'])) ? trim($valid_data['child_number']) : 0,		
						'stars'            	    => (isset($valid_data['stars'])) ? trim($valid_data['stars']) : null,
					    'hotel_name'            => (isset($valid_data['hotel_name'])) ? trim($valid_data['hotel_name']) : null,
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