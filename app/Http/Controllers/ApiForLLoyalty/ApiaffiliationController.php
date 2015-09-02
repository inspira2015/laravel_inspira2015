<?php
namespace App\Http\Controllers\ApiForLLoyalty;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Response;
use Session;
use Auth;
use App\Model\User;
use App\Model\Affiliations;
use App\Model\UserAffiliations as UserAff;


class ApiaffiliationController extends Controller 
{

	public function __construct()
	{

	}


	public function getUseraffiliation($leisure_id = FALSE)
	{
		if ( $leisure_id == FALSE || empty( $leisure_id ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'There is no valid leisure User'
					]
				],400);
		}

		$inspiraUser = User::where( 'leisure_id', $leisure_id )->first();

		if ( empty( $inspiraUser ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was not found'
					]
				],404);	
		}

		$queryAff = UserAff::has('affiliation')->where('users_id', $inspiraUser->id)
		 			->where('active',1)->orderBy('id','desc')->first();

		if( empty( $queryAff->affiliation->tier_id ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have affiliation id'
					]
				],404);	
		}

		return 	Response::json([
				'data' => array('tier_id' => $queryAff->affiliation->tier_id )
			], 200);
	}


	public function putUseraffpayment($leisure_id = FALSE)
	{
		if ( $leisure_id == FALSE || empty( $leisure_id ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'There is no valid leisure User'
					]
				],400);
		}

		$inspiraUser = User::where( 'leisure_id', $leisure_id )->first();

		if ( empty( $inspiraUser ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was not found'
					]
				],404);	
		}

		$queryAff = UserAff::has('affiliation')->where('users_id', $inspiraUser->id)
		 			->where('active',1)->orderBy('id','desc')->first();

		if( empty( $queryAff->affiliation->tier_id ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have affiliation id'
					]
				],404);	
		}

		return 	Response::json([
				'data' => array('tier_id' => $queryAff->affiliation->tier_id )
			], 200);
	}





}