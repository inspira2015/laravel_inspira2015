<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Model\SystemLog as Log;
use Auth; 

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
}
