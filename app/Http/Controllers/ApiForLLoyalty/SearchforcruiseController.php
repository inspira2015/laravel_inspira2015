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


class SearchforcruiseController extends Controller 
{
	
	
	public function __construct()
	{


	}
	
	public function index()
	{
		$searches = ApiSearchCruise::all();

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


			ApiSearchCruise::create(array(
								'leisure_id' => $search['leisure_id'],
								'users_id' => $inspiraUser->id,
								'from' => $search['from'],
								'where' => $search['where'],
								'cruise_line' => $search['cruise_line'],
								'cruise_name' => $search['cruise_name'],
								'cruise_lenght' => $search['cruise_lenght'],
								'adult_number' => $search['adult_number'],
								'child_number' => $search['child_number'],
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