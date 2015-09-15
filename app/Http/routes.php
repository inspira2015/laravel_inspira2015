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

Route::group(['middleware' => 'auth.very_basic'], function() {
	





	


	

});

	Route::put('api/v1/inspirapoints/addpayment/{leisure_id}', 'ApiForLLoyalty\ApiadditionalpaymentsController@Monthlypayment');





	Route::put('api/v1/inspirapoints/earned/{leisure_id}', 'ApiForLLoyalty\InspirapointsController@Pointsearnpermonth');
	Route::put('api/v1/inspirapoints/spended/{leisure_id}', 'ApiForLLoyalty\InspirapointsController@Pointsspendpermonth');
	Route::put('api/v1/inspirapoints/movements/{leisure_id}', 'ApiForLLoyalty\InspirapointsController@Monthlymovements');
	Route::put('api/v1/inspirapoints/concepts/{leisure_id}', 'ApiForLLoyalty\InspirapointsController@Monthlyconceptsmovements');
	Route::put('api/v1/inspirapoints/mbalance/{leisure_id}', 'ApiForLLoyalty\InspirapointsController@Monthlybalance');
	Route::put('api/v1/inspirapoints/balance/{leisure_id}', 'ApiForLLoyalty\InspirapointsController@Currentbalance');



	Route::get('api/v1/booking/tours/', 'ApiForLLoyalty\BookingforatourController@index');
	Route::post('api/v1/booking/tours/create', 'ApiForLLoyalty\BookingforatourController@create');


	Route::get('api/v1/tours/', 'ApiForLLoyalty\SearchforatourController@index');
	Route::post('api/v1/tours/create', 'ApiForLLoyalty\SearchforatourController@create');


	Route::get('api/v1/booking/activities/', 'ApiForLLoyalty\BookingforactivitiesController@index');
	Route::post('api/v1/booking/activities/create', 'ApiForLLoyalty\BookingforactivitiesController@create');

	Route::get('api/v1/activities/', 'ApiForLLoyalty\SearchforactivitiesController@index');
	Route::post('api/v1/activities/create', 'ApiForLLoyalty\SearchforactivitiesController@create');


	Route::get('api/v1/booking/cruise/', 'ApiForLLoyalty\BookingforcruiseController@index');
	Route::post('api/v1/booking/cruise/create', 'ApiForLLoyalty\BookingforcruiseController@create');

	Route::get('api/v1/cruise/', 'ApiForLLoyalty\SearchforcruiseController@index');
	Route::post('api/v1/cruise/create', 'ApiForLLoyalty\SearchforcruiseController@create');


	Route::get('api/v1/cars/', 'ApiForLLoyalty\SearchforcarsController@index');
	Route::post('api/v1/cars/create', 'ApiForLLoyalty\SearchforcarsController@create');

	Route::get('api/v1/booking/cars/', 'ApiForLLoyalty\BookingforcarsController@index');
	Route::post('api/v1/booking/cars/create', 'ApiForLLoyalty\BookingforcarsController@create');


	Route::get('api/v1/flights/', 'ApiForLLoyalty\SearchforflightsController@index');
	Route::post('api/v1/flights/create', 'ApiForLLoyalty\SearchforflightsController@create');

	Route::get('api/v1/booking/lodging', 'ApiForLLoyalty\BookingforlodgingController@index');
	Route::post('api/v1/booking/lodging/create', 'ApiForLLoyalty\BookingforlodgingController@create');

	Route::get('api/v1/lodging/', 'ApiForLLoyalty\SearchforlodgingController@index');
	Route::post('api/v1/lodging/create', 'ApiForLLoyalty\SearchforlodgingController@create');


	Route::get('api/v1/booking/flights', 'ApiForLLoyalty\BookingforflightsController@index');
	Route::post('api/v1/booking/flights/create', 'ApiForLLoyalty\BookingforflightsController@create');


	Route::put('api/v1/affiliation/{leisure_id}', 'ApiForLLoyalty\ApiaffiliationController@getUseraffiliation');
	Route::put('api/v1/affiliation/payment/{leisure_id}', 'ApiForLLoyalty\ApiaffiliationController@putUseraffpayment');
	Route::put('api/v1/affiliation/lastpayment/{leisure_id}', 'ApiForLLoyalty\ApiaffiliationController@putUserafflastpayment');
	Route::put('api/v1/affiliation/nextpayment/{leisure_id}', 'ApiForLLoyalty\ApiaffiliationController@putUseraffnextpayment');
	Route::put('api/v1/affiliation/duepayments/{leisure_id}', 'ApiForLLoyalty\ApiaffiliationController@putUseraffduepayment');


	Route::put('api/v1/vacationalfund/{leisure_id}', 'ApiForLLoyalty\ApivacationalfundsController@Getmonthlyamount');
	Route::put('api/v1/vacationalfund/lastpayment/{leisure_id}', 'ApiForLLoyalty\ApivacationalfundsController@Getlastpayment');
	Route::put('api/v1/vacationalfund/nextpayment/{leisure_id}', 'ApiForLLoyalty\ApivacationalfundsController@Getnextpayment');
	Route::put('api/v1/vacationalfund/duepayments/{leisure_id}', 'ApiForLLoyalty\ApivacationalfundsController@Getuservacduepayments');
	Route::put('api/v1/vacationalfund/withdraw/{leisure_id}', 'ApiForLLoyalty\ApivacationalfundsController@Withdraw');
	Route::put('api/v1/vacationalfund/lastwithdraw/{leisure_id}', 'ApiForLLoyalty\ApivacationalfundsController@GetLastWithdrawDate');
	Route::put('api/v1/vacationalfund/currentbalance/{leisure_id}', 'ApiForLLoyalty\ApivacationalfundsController@GetCurrentBalance');




Route::get('terms', 'WelcomeController@terms');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');


Route::get('cronjob/exchangerate', 'CronJobs\ExchangeRateUpdate@Currentrate');
Route::get('cronjob/affiliationcharge', 'CronJobs\AffiliationCharge@Montlypayment');
Route::get('cronjob/vacationalfunds', 'CronJobs\VacationalFundCharge@Montlypayment');
Route::get('cronjob/cashtransaction', 'CronJobs\CashTransaction@Hourlycheck');


Route::get('api/test', 'Api\UsersController@test');
Route::get('api/users/details', 'Api\UsersController@all');
Route::get('api/users/exists', 'Api\UsersController@exists');
Route::post('api/states', 'Api\StatesController@getByCountryCode');
Route::post('api/user/change-language', 'Api\UsersController@changeLanguage');
Route::post('api/user/change-currency', 'Api\UsersController@changeCurrency');

Route::post('api/users/edit-account', 'Api\UsersController@editAccount');
Route::post('api/states', 'Api\StatesController@getByCountryCode');


// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


Route::get('/', 'UseraccountController@index');

Route::get('/home', 'UseraccountController@index');

//Route::get('/', 'WelcomeController@index');

Route::get('users', 'UsersController@index');		
Route::post('users/registration', 'UsersController@registration');
Route::get('users/activation/{code}', 'UsersController@activation');
Route::post('users/select-language', 'UsersController@refreshLanguage');

Route::get('affiliation', 'AffiliationController@index');
Route::post('affiliation/add', 'AffiliationController@create');
Route::get('affiliation/update/{affiliation?}', 'AffiliationController@changeaffiliation');
Route::post('affiliation/modify', 'AffiliationController@dochange');


Route::get('vacationfund', 'VacationfundsController@index');
Route::post('vacationfund/add', 'VacationfundsController@create');
Route::get('vacationfund/update/{vacationfund?}', 'VacationfundsController@changevacationalfund');
Route::post('vacationfund/modify', 'VacationfundsController@dochange');



Route::get('payment', 'PaymentController@index');
Route::post('payment/addcreditcard', 'PaymentController@Addcreditcard');
Route::get('payment/creditcardinfo', 'PaymentController@Creditcardinfo');

Route::get('codes/{reset?}', 'CodesController@index');
Route::any('codes/nocode', 'CodesController@Continuenocode');

Route::get('useraccount', 'UseraccountController@index');

Route::get('accountsetup', 'UseraccountController@accountSetup');
Route::post('useraccount/update-contact', 'UseraccountController@updateAccount');
Route::post('useraccount/edit-contact', 'UseraccountController@editAccount');
Route::post('useraccount/edit-password', 'UseraccountController@editPassword');
Route::post('useraccount/update-password', 'UseraccountController@updatePassword');
Route::post('useraccount/edit-payment', 'UseraccountController@editPayment');
Route::post('useraccount/update-payment', 'UseraccountController@updatePayment');
Route::get('useraccount/activation/{code}', 'UseraccountController@activation');

Route::post('codes/check', 'CodesController@check');

Route::post('/language', array(
	'before' => 'csrf',
	'as'    =>  'language-choose',
	'uses'  =>  'LanguageController@choose'
));