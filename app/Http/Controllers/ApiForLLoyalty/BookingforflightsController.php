<?php
namespace App\Http\Controllers\ApiForLLoyalty;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Response;
use Session;
use Auth;
use App\Model\ApiSearchFlight;
use App\Model\User;
use App\Libraries\ApiTraits\CleanFlightArray;


class BookingforflightsController extends Controller 
{
	use CleanFlightArray;
	
	public function __construct()
	{


	}
	
	public function index()
	{
		$searches = ApiSearchFlight::where('data_type','BOOKING')->get();

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

			ApiSearchFlight::create(array(
								'leisure_id' => $search['leisure_id'],
								'users_id' => $inspiraUser->id,
								'data_type' => 'BOOKING',
								'from' => $search['from'],
								'where' => $search['where'],
								'type' => $search['type'],
								'start_date' => $search['start_date'],
								'end_date' => $search['end_date'],
								'adult_number' => $search['adult_number'],
								'child_number' => $search['child_number'],
								'air_line' => $search['air_line'],
								'airfare' => $search['airfare'],
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