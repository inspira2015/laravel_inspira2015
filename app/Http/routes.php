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




//Codes
Route::get('/codes', 'CodesController@index');
Route::post('/codes/check', 'CodesController@check');


//Users
Route::get('/user', 'UsersController@index');



Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');





Route::controller('affiliations', 'AffiliationsController');
Route::controller('vacationfunds', 'VacationfundsController');
Route::controller('creditcards', 'CreditcardsController');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
