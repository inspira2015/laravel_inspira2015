<?php
namespace App\Http\Controllers\ApiForLLoyalty;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Response;
use App\Model\User;
use App\Model\ApiSearchLoadging;
use App\Libraries\ApiTraits\CleanLodgingArray;
use App\Model\ApiStorageMaster;


class BookingforlodgingController extends Controller 
{
	use CleanLodgingArray;
	
	public function __construct()
	{


	}
	
	public function index()
	{
		$searches = ApiStorageMaster::where('api_type','LODGING')->where('data_type','BOOKING')
			->select( 'id','leisure_id','users_id','lodging_type','destination','start_date','end_date',
				'adult_number','child_number','lodging_stars','lodging_hotel_name','booking_amount',
				'booking_date','booking_payment_type','key_words' )->get();
 

		return 	Response::json([
				'data' => $searches->toArray()
			], 200);
	}



	public function create()
	{
		$searches = Request::all();
		$flag_partial = 0;
		$flag_notauser = FALSE;

		if ( empty( $searches ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'There is no valid Json Post'
					]
				],404);
		}


		foreach($searches as $search)
		{


			if( !isset($search['leisure_id']) || empty($search['leisure_id']) )
			{
				$flag_partial = 1;
				continue;
			}
			$inspiraUser = User::where('leisure_id', $search['leisure_id'])->first();

			if ( empty( $inspiraUser ) )
			{
				$flag_notauser = TRUE;
				continue;
			}

			$search = $this->exchangeArray( $search );
			ApiStorageMaster::create(array(
								'leisure_id' => $search['leisure_id'],
								'users_id' => $inspiraUser->id,
								'data_type' => 'BOOKING',
								'api_type' => 'LODGING',
								'lodging_type' => $search['type'],
								'destination' => $search['destination'],
								'start_date' => $search['start_date'],
								'end_date' => $search['end_date'],
								'adult_number' => $search['adult_number'],
								'child_number' => $search['child_number'],
								'lodging_stars' => $search['stars'],
								'lodging_hotel_name' => $search['hotel_name'],
								'booking_amount' => $search['booking_amount'],
								'booking_date' => $search['booking_date'],
								'booking_payment_type' => $search['booking_payment_type'],
								'key_words' => $search['key_words'],
				));

		}

		if($flag_partial == 1)
		{
			return Response::json([
					'response'=> [
						'success' => 'Partial',
						'message' => 'There was some data could not been add to database'
					]
				],206);
		}

		return Response::json([
					'response'=> [
						'success' => 'OK',
					]
				],201);
		
	}





}