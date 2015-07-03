<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');


Route::post('/language', array(

'before' => 'csrf',
'as'    =>  'language-choose',
'uses'  =>  'LanguageController@choose'

));

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::any('/{module}/{action?}/', function( $module = '', $action = '' )
{
	$controller = Str::title( $module ).'Controller';
	
	if( Request::method() == 'GET' )
	{
		if( $action )
		{
			return View::make('errors.404');
		}
		$action = 'Index';
	}

	try 
	{
		return App::make("\App\\Http\\Controllers\\{$controller}")->logAction($module, $action)->$action();
    } catch(ReflectionException $e) {
		return View::make('errors.404');
    }
});


