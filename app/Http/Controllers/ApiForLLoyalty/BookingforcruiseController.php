<?php
namespace App\Http\Controllers\ApiForLLoyalty;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Response;
use Session;
use Auth;
use App\Model\ApiSearchCruise;
use App\Model\User;
use App\Model\ApiStorageMaster;
use App\Libraries\ApiTraits\CleanCruiseArray;


class BookingforcruiseController extends Controller 
{
	use CleanCruiseArray;
	
	public function __construct()
	{

	}
	
	public function index()
	{
		$searches = ApiStorageMaster::where('api_type','CRUISE')->where('data_type','BOOKING')
			->select( 'id','leisure_id','users_id','from','destination', 'cruise_line',
				'cruise_name','cruise_lenght','start_date','adult_number','child_number','key_words','booking_amount',
				'booking_date','booking_payment_type','created_at'  )->get();

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

			$search = $this->exchangeArray( $search );

			ApiStorageMaster::create(array(
								'leisure_id' => $search['leisure_id'],
								'users_id' => $inspiraUser->id,
								'data_type' => 'BOOKING',
								'api_type' => 'CRUISE',
								'from' => $search['from'],
								'destination' => $search['where'],
								'cruise_line' => $search['cruise_line'],
								'cruise_name' => $search['cruise_name'],
								'cruise_lenght' => $search['cruise_lenght'],
								'start_date' => $search['start_date'],
								'adult_number' => $search['adult_number'],
								'child_number' => $search['child_number'],
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