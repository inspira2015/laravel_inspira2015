<?php
namespace App\Http\Controllers\ApiForLoyalty;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Response;
use Session;
use Auth;
use App\Model\ApiSearchActivities;
use App\Model\User;
use App\Model\ApiStorageMaster;


class BookingforactivitiesController extends Controller 
{
	
	
	public function __construct()
	{


	}
	
	public function index()
	{
		$searches = ApiStorageMaster::where('api_type','ACTIVITIES')->where('data_type','BOOKING')
			->select( 'id','leisure_id','users_id','from','destination', 'activity_category',
				'search_date','adult_number','child_number','key_words','booking_amount',
				'booking_date','booking_payment_type', 'created_at'  )->get();


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
			$inspiraUser = User::where('leisure_id', $searches[0]['leisure_id'])->first();

			if ( empty( $inspiraUser ) )
			{
				$flag_notauser = TRUE;
				continue;
			}


			ApiStorageMaster::create(array(
								'leisure_id' => $search['leisure_id'],
								'users_id' => $inspiraUser->id,
								'data_type' => 'BOOKING',
								'api_type' => 'ACTIVITIES',
								'destination' => $search['destination'],
								'activity_category' => $search['category'],
								'adult_number' => $search['adult_number'],
								'child_number' => $search['child_number'],
								'search_date' => $search['search_date'],
								'booking_amount' => $search['booking_amount'],
								'booking_date' => $search['booking_date'],
								'booking_payment_type' => $search['booking_payment_type'],
								'key_words' => $search['key_words'],
				));
		}

		if($flag_partial == 1 || $flag_notauser == TRUE )
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