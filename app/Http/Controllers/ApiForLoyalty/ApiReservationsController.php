<?php
namespace App\Http\Controllers\ApiForLoyalty;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Response;

class ApiReservationsController extends Controller 
{
	
	public function addReservation(){
		return Response::json([
			'response'=> [
				'success' => 'Success',
				'message' => 'API working'
			]
		],200);
	}
}