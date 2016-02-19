<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Model\SystemLog as Log;
use App\Model\Entity\LogEntity;
use Auth; 
use App;
use Lang;
use Session;
use Response;

abstract class Controller extends BaseController {
	protected $logDao;
	
	use DispatchesCommands, ValidatesRequests;

	
	public function setLanguage( $locale = null )
	{
		$lang = (!empty($locale)) ? $locale : Lang::locale();
		
		if( Auth::check() )
		{
			$lang =  Auth::user()->language;
		}
		else if( Session::get('users.language') ){
			$lang = Session::get('users.language');
		}
				
		App::setLocale($lang);
	}
	
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
	
	
	
	public function actionLog( Array $data ){
		$this->logDao = new LogEntity();
		$this->logDao->exchangeArray($data);
		return $this->logDao->save();
	}
	public function encrypt_decrypt($action, $string) {
	    $output = false;
	
	    $encrypt_method = "AES-256-CBC";
	    $secret_key = 'Nsp1r4M3x1c0';
	    $secret_iv = 'IV12';
	
	    // hash
	    $key = hash('sha256', $secret_key);
	    
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);
	
	    if( $action == 'encrypt' ) {
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    }
	    else if( $action == 'decrypt' ){
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }
	
	    return $output;
	}

	protected function timeDiff($expiration_date, $now){
		return round((strtotime($expiration_date)-strtotime($now))/86400);
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

		if ( Session::has('full_name') )
		{
			Session::forget('full_name');	
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
	
	protected function htmlResponseContinue( $message, $redirect  = 'false' ) {
		return Response::json(array(
			'error' => false,
			'html' => htmlspecialchars( view('layouts.__common.message_continue', array('message' => $message )) ),
			'redirect' => $redirect
		), 200);
	}
}
