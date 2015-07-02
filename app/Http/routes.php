<?php
use Illuminate\Support\Str;
///use App\Http\Controllers\CodesController as CodeController;
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

//Codes
Route::any('/{module}/{action?}/', function( $module = '', $action = '' )
{
	$action = empty($action) ? 'Index' : $action;
	$controller = Str::title($module).'Controller';
	$complete_route = "\App\\Http\\Controllers\\{$controller}";
	return App::make($complete_route)->logAction($module, $action)->$action();
});

//Users
Route::get('/user', 'UsersController@index');
Route::post('/user/registration', 'UsersController@registration');


//Affiliations
Route::get('/affiliation', 'AffiliationsController@index');


//VacationalFund
Route::get('/affiliation', 'AffiliationsController@index');


//CreditCardInfo
Route::get('/payments', 'CreditcardsController@index');
Route::put('/payments/subtotal', 'CreditcardsController@subtotal');

Route::get('home', 'HomeController@index');


Route::post('/language', array(

'before' => 'csrf',
'as'    =>  'language-choose',
'uses'  =>  'LanguageController@choose'

));

Route::controller('codes', 'CodesController');
Route::controller('affiliations', 'AffiliationsController');
Route::controller('vacationfunds', 'VacationfundsController');
Route::controller('creditcards', 'CreditcardsController');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


