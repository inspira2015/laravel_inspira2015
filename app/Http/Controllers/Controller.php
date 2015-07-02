<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Model\SystemLog as Log;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;


	public function logAction( $module = 'Home', $action = 'View'){
		$log = new Log();
		$log->type_of_transaction = $action;
		$log->table = $module;
		$log->save();
		
		return $this;
	}
}
