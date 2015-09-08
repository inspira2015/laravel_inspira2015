<?php 
namespace App\Libraries\ApiTraits;


trait CleanCarArray
{
    public function exchangeArray(array $valid_data)
	{
       
       return array( 
				       'leisure_id'             => (isset($valid_data['leisure_id'])) ? trim($valid_data['leisure_id']) : null,
						'from'        			=> (isset($valid_data['from'])) ? trim($valid_data['from']) : null,
				        'start_date'            => (isset($valid_data['start_date'])) ? trim($valid_data['start_date']) : null,
				        'where'                 => (isset($valid_data['where'])) ? trim($valid_data['where']) : null,
				        'type'            		=> (isset($valid_data['type'])) ? trim($valid_data['type']) : null,
				       	'end_date'              => (isset($valid_data['end_date'])) ? trim($valid_data['end_date']) : null,
				        'car_type'          	=> (isset($valid_data['car_type'])) ? trim($valid_data['car_type']) : null,
				        'payment_type'          => (isset($valid_data['payment_type'])) ? trim($valid_data['payment_type']) : null,		
				        'key_words'             => (isset($valid_data['key_words'])) ? trim($valid_data['key_words']) : null,
				        'booking_amount'        => (isset($valid_data['booking_amount'])) ? trim($valid_data['booking_amount']) : null,
					    'booking_date'          => (isset($valid_data['booking_date'])) ? trim($valid_data['booking_date']) : null,
				        'booking_payment_type'  => (isset($valid_data['booking_payment_type'])) ? trim($valid_data['booking_payment_type']) : null,
				    );
	}
   
}