<?php
namespace App\Http\Controllers\ApiForLoyalty;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Response;
use Input;
use App\Model\User;
use App\Model\ApiSearchLodging;
use App\Libraries\ApiTraits\CleanLodgingArray;
use App\Model\ApiStorageMaster;


class SearchforlodgingController extends Controller 
{
	use CleanLodgingArray;

	private $lodgingView;

	
	public function __construct()
	{

	}
	
	public function index()
	{
		$searches = ApiStorageMaster::where('api_type','LODGING')->where('data_type','SEARCH')
			->select( 'id','leisure_id','users_id','lodging_type','destination','start_date','end_date',
				'adult_number','child_number','lodging_stars','lodging_hotel_name','key_words','created_at' )->get();
 
		return 	Response::json([
				'data' => $searches->toArray()
			], 200);
	}


	public function create()
	{
		$searches = Request::all();
		$flag_partial = 0;
		$flag_notauser = FALSE;
/*
		print_r($searches);
		exit;
*/
		if ( empty( $searches ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'There is no valid Json Post'
					]
				],404);
		}
	
		foreach($searches as $index => $search)
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
								'data_type' => 'SEARCH',
								'api_type' => 'LODGING',
								'lodging_type' => $search['lodging_type'],
								'destination' => $search['destination'],
								'start_date' => $search['start_date'],
								'end_date' => $search['end_date'],
								'adult_number' => $search['adult_number'],
								'child_number' => $search['child_number'],
								'lodging_stars' => $search['stars'],
								'lodging_hotel_name' => $search['hotel_name'],
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