<?php
namespace App\Http\Controllers\ApiForLLoyalty;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Response;
use App\Model\User;
use App\Model\VacationFundLog as UserVacLog;
use App\Model\UserVacationalFunds as UserVacFunds;

use App\Libraries\GeneratePaymentsDates;
use App\Libraries\CheckDuePayments;


class ApivacationalfundsController extends Controller 
{

	public function __construct()
	{

	}

	/**
	 * Get Monthly Vacational Fund Payment
	 *
	 * @return Json tier_id
	 */
	public function Getmonthlyamount($leisure_id = FALSE)
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

		$queryVacLog = UserVacLog::where('users_id', $inspiraUser->id )->where('active',1)->orderBy('id','desc')->first();


		if( $queryVacLog->amount == 0 )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have Vacational Fund Set'
					]
				], 404 );	
		}

		$amount = number_format($queryVacLog->amount, 2, '.', '');
		return 	Response::json([
				'data' => array( 'amount' => $amount,
								 'currency' => $queryVacLog->currency )
			], 200);
	}


	/**
	 * Get Monthly Vacational Fund Payment
	 *
	 * @return Json tier_id
	 */
	public function Getlastpayment($leisure_id = FALSE)
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

		$queryVacFund = UserVacFunds::where('users_id', $inspiraUser->id )->orderBy('id','desc')->first();


		if( empty( $queryVacFund ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have Vacational Fund Set'
					]
				], 404 );	
		}

		list($date, $time) = explode( ' ', $queryVacFund->created_at );
		return 	Response::json([
				'data' => array( 'last_payment' => $date )
			], 200);
	}

	/**
	 * Get Next Monthly Vacational Fund Payment
	 *
	 * @return Json tier_id
	 */
	public function Getnextpayment($leisure_id = FALSE)
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

		$queryVacFund = UserVacFunds::where('users_id', $inspiraUser->id )->orderBy('id','desc')->first();


		if( empty( $queryVacFund ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have Vacational Fund Set'
					]
				], 404 );	
		}

		list($date, $time) = explode( ' ', $queryVacFund->created_at );
		$objGeneratePaymentsDates = new GeneratePaymentsDates();
		$objGeneratePaymentsDates->setDate( $date );
		$objGeneratePaymentsDates->setBillableDay( $inspiraUser->billable_day );

		return 	Response::json([
				'data' => array( 'next_payment' => $objGeneratePaymentsDates->getNextPaymentDate() )
			], 200);
	}


	/**
	 * Get Due Payments
	 *
	 * @return Json 
	 */
	public function Getuservacduepayments($leisure_id = FALSE)
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

		$queryAff = UserAffPayments::where('users_id', $inspiraUser->id)->orderBy('id','desc')->first();
		$objGeneratePaymentsDates = new GeneratePaymentsDates();
		$objGeneratePaymentsDates->setDate( $queryAff->charge_at );
		$objGeneratePaymentsDates->setBillableDay( $inspiraUser->billable_day );

		$objCheckDuePayments = new CheckDuePayments();
		$objCheckDuePayments->setStartDate( $objGeneratePaymentsDates->getNextPaymentDate() );
		$objCheckDuePayments->setEndDate( \date('Y-m-d') );


		if( empty( $queryAff->charge_at ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have Vacational found set'
					]
				],404);	
		}

		return 	Response::json([
				'data' => array( 'due_payments' => $objCheckDuePayments->getNumberOfDuePayments() )
			], 200);
	}



}