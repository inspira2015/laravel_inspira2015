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


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('terms', 'WelcomeController@terms');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');


Route::get('cronjob/exchangerate', 'CronJobs\ExchangeRateUpdate@Currentrate');


Route::get('api/test', 'Api\UsersController@test');
Route::get('api/users/details', 'Api\UsersController@all');
Route::get('api/users/exists', 'Api\UsersController@exists');
Route::post('api/user/change-language', 'Api\UsersController@changeLanguage');


Route::post('api/users/edit-account', 'Api\UsersController@editAccount');
Route::post('api/states', 'Api\StatesController@getByCountryCode');


// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('/', 'WelcomeController@index');

Route::get('users', 'UsersController@index');		
Route::post('users/registration', 'UsersController@registration');
Route::get('users/activation/{code}', 'UsersController@activation');

Route::get('affiliation', 'AffiliationController@index');
Route::post('affiliation/add', 'AffiliationController@create');

Route::get('vacationfund', 'VacationfundsController@index');
Route::post('vacationfund/add', 'VacationfundsController@create');



Route::get('payment', 'PaymentController@index');
Route::post('payment/addcreditcard', 'PaymentController@Addcreditcard');
Route::get('payment/creditcardinfo', 'PaymentController@Creditcardinfo');

Route::get('codes/{reset?}', 'CodesController@index');

Route::get('useraccount', 'UseraccountController@index');

Route::get('accountsetup', 'UseraccountController@accountSetup');
Route::post('useraccount/update-contact', 'UseraccountController@updateAccount');
Route::post('useraccount/edit-contact', 'UseraccountController@editAccount');
Route::post('useraccount/edit-password', 'UseraccountController@editPassword');
Route::post('useraccount/update-password', 'UseraccountController@updatePassword');

Route::post('codes/check', 'CodesController@check');

Route::post('/language', array(
	'before' => 'csrf',
	'as'    =>  'language-choose',
	'uses'  =>  'LanguageController@choose'
));