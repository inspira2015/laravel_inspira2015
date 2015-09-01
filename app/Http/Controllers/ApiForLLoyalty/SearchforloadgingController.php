<?php
namespace App\Http\Controllers\ApiForLLoyalty;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Response;
use Session;
use Auth;
use App\Model\ApiSearchLoadging;

class SearchforloadgingController extends Controller 
{
	
	
	public function __construct()
	{


	}
	
	public function index()
	{
		$searches = ApiSearchLoadging::all();

		return 	Response::json([
				'data' => $searches->toArray()
			], 200);
	}


	public function show($id)
	{
		$searches = ApiSearchLoadging::all();

		return 	Response::json([
				'data' => $searches->toArray()
			], 200);
	}



	public function create()
	{
		$searches = Request::all();
		$flag_partial = 0;
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
			ApiSearchLoadging::create(array(
								'leisure_id' => $search['leisure_id'],
								'type' => $search['type'],
								'destiny' => $search['destiny'],
								'start_date' => $search['start_date'],
								'end_date' => $search['end_date'],
								'adult_number' => $search['adult_number'],
								'child_number' => $search['child_number'],
								'stars' => $search['stars'],
								'hotel_name' => $search['hotel_name'],
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
		print_r($searches);



		
	}


	/*public function create($id)
	{
		$searches = ApiSearchLoadging::all();

		return 	Response::json([
				'data' => $searches->toArray()
			], 200);
	}*/


}