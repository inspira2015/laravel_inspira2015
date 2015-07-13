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


// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');


Route::get('api/test', 'Api\UsersController@test');
Route::get('api/users/details', 'Api\UsersController@all');

Route::post('api/users/edit-account', 'Api\UsersController@editAccount');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('/', 'WelcomeController@index');

Route::get('users', 'UsersController@index');		
Route::post('users/registration', 'UsersController@registration');
Route::get('users/activation/{code}', 'UsersController@activation');

Route::get('affiliation', 'AffiliationController@index');

Route::get('payment', 'PaymentController@index');
Route::put('payment/subtotal', 'PaymentController@subtotal');

Route::get('codes', 'CodesController@index');

Route::get('useraccount', 'UseraccountController@index');
Route::post('useraccount/update-contact', 'UseraccountController@updateAccount');
Route::post('useraccount/edit-contact', 'UseraccountController@editAccount');
Route::post('useraccount/edit-details', 'UseraccountController@editDetails');
Route::post('useraccount/update-details', 'UseraccountController@updateDetails');
Route::post('useraccount/edit-language', 'UseraccountController@editLanguage');

Route::post('codes/check', 'CodesController@check');

Route::post('/language', array(
	'before' => 'csrf',
	'as'    =>  'language-choose',
	'uses'  =>  'LanguageController@choose'
));