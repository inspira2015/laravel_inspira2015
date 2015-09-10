<?php
namespace App\Http\Controllers\ApiForLLoyalty;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Response;
use DB;
use App\Model\User;
use App\Model\VacationFundLog as UserVacLog;
use App\Model\UserVacationalFunds as UserVacFunds;

use App\Libraries\GeneratePaymentsDates;
use App\Libraries\CheckDuePayments;
use App\Libraries\SystemTransactions\WithdrawVacationalFunds;





class ApiadditionalpaymentsController extends Controller 
{
	

	public function __construct(  )
	{
		
	}



	/**
	 * Get Monthly Vacational Fund Payment
	 *
	 * @return Json tier_id
	 */
	public function Monthlypayment($leisure_id = FALSE)
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

		$queryInspira = UserVacFunds::where('users_id', $inspiraUser->id )
						->where(DB::raw('YEAR(created_at)'), '=', $year)
						->where(DB::raw('MONTH(created_at)'), '=', $month)
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




}