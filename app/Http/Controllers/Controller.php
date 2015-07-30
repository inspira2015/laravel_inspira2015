<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Model\SystemLog as Log;
use Auth; 
use Session;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	public function logAction( $module, $action, $method)
	{
		$action = ($action == null ) ? 'Index' : $action;

		$log = new Log();
		$log->action = $action;
		$log->module = $module;
		$log->method = $method;
		$log->users_id = Auth::check() ? Auth::user()->id : null;
		$log->save();
		
		return $this;
	}


	protected function deleteSessionData()
	{
		if ( Session::has('code') )
		{
			Session::forget('code');			
		}

		if ( Session::has('users') )
		{
			Session::forget('users');			
		}

		if ( Session::has('affiliation') )
		{
			Session::forget('affiliation');			
		}

		if ( Session::has('vacationfund') )
		{
			Session::forget('vacationfund');			
		}
	}
}
