<?php
namespace App\Http\Controllers\ApiForLLoyalty;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Response;
use DB;
use App\Model\User;
use App\Model\UsersPoints;
use App\Model\UserVacationalFunds as UserVacFunds;

use App\Libraries\GeneratePaymentsDates;
use App\Libraries\CheckDuePayments;
use App\Libraries\SystemTransactions\WithdrawVacationalFunds;





class InspirapointsController extends Controller 
{

	public function __construct()
	{

	}


	/**
	 * Get Monthly Vacational Fund Payment
	 *
	 * @return Json tier_id
	 */
	public function Pointsearnpermonth($leisure_id = FALSE)
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
		$post = Request::all();

		$year_month = $post['year_month'];

		if ( empty( $year_month ) )
		{
			$year_month = date('Y-m');
		}

		list( $year , $month ) = explode( '-', $year_month );

		$queryInspira = UsersPoints::where('users_id', $inspiraUser->id )
						->where(DB::raw('YEAR(created_at)'), '=', $year)
						->where(DB::raw('MONTH(created_at)'), '=', $month)
						->orderBy('id','desc')->get();

		if( empty( $queryInspira ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have Inspira Points'
					]
				], 404 );	
		}

		$inspiraPoints = $this->totalAddedPoints( $queryInspira );

		$amount = number_format( $inspiraPoints, 0, '.', '' );
		return 	Response::json([
				'data' => array( 'points' => $amount )
			], 200);
	}

	/**
	 * Get Monthly Vacational Fund Payment
	 *
	 * @return Json tier_id
	 */
	public function Pointsspendpermonth($leisure_id = FALSE)
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
		$post = Request::all();

		$year_month = $post['year_month'];

		if ( empty( $year_month ) )
		{
			$year_month = date('Y-m');
		}

		list( $year , $month ) = explode( '-', $year_month );

		$queryInspira = UsersPoints::where('users_id', $inspiraUser->id )
						->where(DB::raw('YEAR(created_at)'), '=', $year)
						->where(DB::raw('MONTH(created_at)'), '=', $month)
						->orderBy('id','desc')->get();


		if( empty( $queryInspira ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have Inspira Points'
					]
				], 404 );	
		}

		$inspiraPoints = $this->totalSubstractedPoints( $queryInspira );

		$amount = number_format( $inspiraPoints, 0, '.', '' );
		return 	Response::json([
				'data' => array( 'points' => $amount )
			], 200);
	}


	/**
	 * Get Monthly Vacational Fund Payment
	 *
	 * @return Json tier_id
	 */
	public function Monthlymovements($leisure_id = FALSE)
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
		$post = Request::all();

		$year_month = $post['year_month'];

		if ( empty( $year_month ) )
		{
			$year_month = date('Y-m');
		}

		list( $year , $month ) = explode( '-', $year_month );

		$queryInspira = UsersPoints::where('users_id', $inspiraUser->id )
						->where(DB::raw('YEAR(created_at)'), '=', $year)
						->where(DB::raw('MONTH(created_at)'), '=', $month)
						->orderBy('id','desc')->get();


		if( empty( $queryInspira ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have Inspira Points'
					]
				], 404 );	
		}

		$inspiraArray = $this->builtMovementArray( $queryInspira );

		//$amount = number_format( $inspiraPoints, 0, '.', '' );
		return 	Response::json([
				'data' => $inspiraArray
			], 200);
	}

	/**
	 * Get Monthly Vacational Fund Payment
	 *
	 * @return Json tier_id
	 */
	public function Monthlyconceptsmovements($leisure_id = FALSE)
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
		$post = Request::all();

		$year_month = $post['year_month'];

		if ( empty( $year_month ) )
		{
			$year_month = date('Y-m');
		}

		list( $year , $month ) = explode( '-', $year_month );

		$queryInspira = UsersPoints::where('users_id', $inspiraUser->id )
						->where(DB::raw('YEAR(created_at)'), '=', $year)
						->where(DB::raw('MONTH(created_at)'), '=', $month)
						->orderBy('id','desc')->get();


		if( empty( $queryInspira ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have Inspira Points'
					]
				], 404 );	
		}

		$inspiraArray = $this->builtConceptArray( $queryInspira );

		//$amount = number_format( $inspiraPoints, 0, '.', '' );
		return 	Response::json([
				'data' => $inspiraArray
			], 200);
	}

	/**
	 * Get Monthly Vacational Fund Payment
	 *
	 * @return Json tier_id
	 */
	public function Monthlybalance($leisure_id = FALSE)
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
		$post = Request::all();

		$year_month = $post['year_month'];

		if ( empty( $year_month ) )
		{
			$year_month = date('Y-m');
		}

		list( $year , $month ) = explode( '-', $year_month );

		$queryInspira = UsersPoints::where('users_id', $inspiraUser->id )
						->where(DB::raw('YEAR(created_at)'), '=', $year)
						->where(DB::raw('MONTH(created_at)'), '=', $month)
						->where( 'description', 'Cash Settled' )
						->orderBy('id','desc')->first();


		if( empty( $queryInspira ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have Inspira Points'
					]
				], 404 );	
		}

		//$inspiraArray = $this->builtConceptArray( $queryInspira );

		$amount = number_format( $queryInspira->balance, 0, '.', '' );
		return 	Response::json([
				'data' => array( 'points' => $amount )
			], 200);
	}


	/**
	 * Get Monthly Vacational Fund Payment
	 *
	 * @return Json tier_id
	 */
	public function Currentbalance($leisure_id = FALSE)
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
		$post = Request::all();

		$year_month = $post['year_month'];

		if ( empty( $year_month ) )
		{
			$year_month = date('Y-m');
		}

		list( $year , $month ) = explode( '-', $year_month );

		$queryInspira = UsersPoints::where('users_id', $inspiraUser->id )
						->orderBy('id','desc')->first();


		if( empty( $queryInspira ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have Inspira Points'
					]
				], 404 );	
		}

		//$inspiraArray = $this->builtConceptArray( $queryInspira );

		$amount = number_format( $queryInspira->balance, 0, '.', '' );
		return 	Response::json([
				'data' => array( 'points' => $amount )
			], 200);
	}






	private function builtConceptArray( $inspiraPoints )
	{
		$inspiraArray = array();
		foreach( $inspiraPoints as $inspira )
		{
			if ( $inspira->added_points > 0 )
			{
				$operation_type = 'Points Earned';
				$amount = $inspira->added_points;

			}
			else
			{
				$operation_type = 'Points Spended';
				$amount = $inspira->substracted_points;
			}
			$inspiraArray[] = array( 'Date' => $this->cleanDate( $inspira->created_at ),
									 'Description' => $inspira->description,
									  $operation_type => $amount ); 
		}

		return $inspiraArray;
	}

	private function builtMovementArray( $inspiraPoints )
	{
		$inspiraArray = array();
		foreach( $inspiraPoints as $inspira )
		{
			if ( $inspira->added_points > 0 )
			{
				$operation_type = 'Points Earned';
				$amount = $inspira->added_points;

			}
			else
			{
				$operation_type = 'Points Spended';
				$amount = $inspira->substracted_points;
			}
			$inspiraArray[] = array( 'Date' => $this->cleanDate( $inspira->created_at ),
									  $operation_type => $amount ); 
		}

		return $inspiraArray;
	}


	private function cleanDate( $timestamp )
	{
		list( $date, $time ) = explode( ' ', $timestamp );
		return $date;
	}


	private function totalSubstractedPoints( $inspiraPoints )
	{
		$inspira_substracted = 0;
		foreach( $inspiraPoints as $inspira )
		{
			$inspira_substracted += $inspira->substracted_points;
		}

		return $inspira_substracted;
	}


	private function totalAddedPoints( $inspiraPoints )
	{
		$inspira_added = 0;
		foreach( $inspiraPoints as $inspira )
		{
			$inspira_added += $inspira->added_points;
		}

		return $inspira_added;
	}


}