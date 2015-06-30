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
//	Route::get('/code', 'CodesController@index');


/*
Route::any('/{module}/{action?}',function($module = '', $action = ''){
	Route::get('/code', 'CodesController@index');
});
*/


//Codes
Route::get('/codes', 'CodesController@index');

Route::post('/codes/check', 'CodesController@check');


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




Route::get('/', 'WelcomeController@index');
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
