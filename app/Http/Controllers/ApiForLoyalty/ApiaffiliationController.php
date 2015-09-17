<?php
namespace App\Http\Controllers\ApiForLoyalty;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Response;
use Session;
use Auth;
use App\Model\User;
use App\Model\Affiliations;
use App\Model\UserAffiliations as UserAff;
use App\Model\UserAffiliationPayment as UserAffPayments;
use App\Libraries\GeneratePaymentsDates;
use App\Libraries\CheckDuePayments;


class ApiaffiliationController extends Controller 
{

	public function __construct()
	{

	}

	/**
	 * Get Affiliation type tier_id
	 *
	 * @return Json tier_id
	 */
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
				], 404 );	
		}

		return 	Response::json([
				'data' => array('tier_id' => $queryAff->affiliation->tier_id )
			], 200 );
	}


	/**
	 * Get Monthly Payment $$
	 *
	 * @return Json 
	 */
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

		if( empty( $queryAff->amount ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have affiliation amount'
					]
				],404);	
		}

		$amount = number_format($queryAff->amount, 2, '.', '');
		return 	Response::json([
				'data' => array( 'amount' => $amount,
								 'currency' => $queryAff->currency )
			], 200);
	}


	/**
	 * Get Last Payment Date
	 *
	 * @return Json 
	 */
	public function putUserafflastpayment($leisure_id = FALSE)
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


		if( empty( $queryAff->charge_at ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have affiliation date'
					]
				],404);	
		}

		return 	Response::json([
				'data' => array( 'last_payment' => $queryAff->charge_at )
			], 200);
	}


	/**
	 * Get Next Payment Date
	 *
	 * @return Json 
	 */
	public function putUseraffnextpayment($leisure_id = FALSE)
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

		if( empty( $queryAff->charge_at ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have affiliation date'
					]
				],404);	
		}

		return 	Response::json([
				'data' => array( 'next_payment' => $objGeneratePaymentsDates->getNextPaymentDate() )
			], 200);
	}


	/**
	 * Get Due Payments
	 *
	 * @return Json 
	 */
	public function putUseraffduepayment($leisure_id = FALSE)
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

		$objCheckDuePayments = new CheckDuePayments();
		$objCheckDuePayments->setStartDate( $objGeneratePaymentsDates->getNextPaymentDate() );
		$objCheckDuePayments->setEndDate( \date('Y-m-d') );


		if( empty( $queryAff->charge_at ) )
		{
			return Response::json([
					'response'=> [
						'success' => 'Error',
						'message' => 'The Leisure user was found but did not have affiliation date'
					]
				],404);	
		}

		return 	Response::json([
				'data' => array( 'due_payments' => $objCheckDuePayments->getNumberOfDuePayments() )
			], 200);
	}


}