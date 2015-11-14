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

Route::group(array('domain' => Config::get('domain.uber')), function(){
	Route::get('/', 'Uber\PageController@index');
	Route::get('destino/mazatlan', 'Uber\PageController@goMazatlan');
	Route::get('destino/las-vegas', 'Uber\PageController@goLasVegas');
	Route::get('destino/malaga', 'Uber\PageController@goMalaga');
	Route::get('destino/puerto-vallarta', 'Uber\PageController@goPuertoVallarta');
	Route::get('destino', 'Uber\PageController@goDestination');
	
	Route::post('usar-semana', 'Uber\CertificatesController@postUseWeek');
	Route::get('comprar-certificado', 'Uber\CertificatesController@getBuyCertificate');
	Route::get('registro', 'Uber\UsersController@getRegister');
	Route::post('registrar', 'Uber\UsersController@postRegister');
	Route::get('api/users/exists', 'Api\UsersController@exists');
	Route::post('pagar-certificado', 'Uber\CertificatesController@postBuyCertificate');

	Route::post('leisure-login', 'Uber\AuthController@postLeisureAutologin');
	Route::post('login', 'Uber\AuthController@postLogin');
	Route::get('logout', 'Uber\AuthController@getLogout');
	Route::post('olvido-contrasena', 'Uber\AuthController@postForgotPassword');
	Route::post('restablecer-contrasena', 'Uber\AuthController@postResetPassword');

	Route::get('/admin', 'Uber\Admin\PageController@index');
	Route::post('/nueva-tarjeta', 'Uber\CertificatesController@newCreditCard');
	Route::post('/tarjeta-registrada', 'Uber\CertificatesController@useCreditCard');
});


Route::group(array('domain' => Config::get('domain.api')), function(){
	Route::any('/', function(){
		return json_encode(['message' => 'Please use api key']);
	});
	Route::put('reservation/?apiKey=test', 'Api\ReservationsController@addReservation');
});



Route::group(array('domain' => Config::get('domain.front')), function(){

	Route::put('api/v1/inspirapoints/addpayment/{leisure_id}', 'ApiForLoyalty\ApiadditionalpaymentsController@Monthlypayment');
	Route::put('api/v1/inspirapoints/earned/{leisure_id}', 'ApiForLoyalty\InspirapointsController@Pointsearnpermonth');
	Route::put('api/v1/inspirapoints/spent/{leisure_id}', 'ApiForLoyalty\InspirapointsController@Pointsspendpermonth');
	Route::put('api/v1/inspirapoints/movements/{leisure_id}', 'ApiForLoyalty\InspirapointsController@Monthlymovements');
	Route::put('api/v1/inspirapoints/concepts/{leisure_id}', 'ApiForLoyalty\InspirapointsController@Monthlyconceptsmovements');
	Route::put('api/v1/inspirapoints/mbalance/{leisure_id}', 'ApiForLoyalty\InspirapointsController@Monthlybalance');
	Route::put('api/v1/inspirapoints/balance/{leisure_id}', 'ApiForLoyalty\InspirapointsController@Currentbalance');



	Route::get('api/v1/booking/tours/', 'ApiForLoyalty\BookingforatourController@index');
	Route::post('api/v1/booking/tours/create', 'ApiForLoyalty\BookingforatourController@create');

	Route::get('api/v1/tours/', 'ApiForLoyalty\SearchforatourController@index');
	Route::post('api/v1/tours/create', 'ApiForLoyalty\SearchforatourController@create');

	Route::get('api/v1/booking/activities/', 'ApiForLoyalty\BookingforactivitiesController@index');
	Route::post('api/v1/booking/activities/create', 'ApiForLoyalty\BookingforactivitiesController@create');

	Route::get('api/v1/activities/', 'ApiForLoyalty\SearchforactivitiesController@index');
	Route::post('api/v1/activities/create', 'ApiForLoyalty\SearchforactivitiesController@create');

	Route::get('api/v1/booking/cruise/', 'ApiForLoyalty\BookingforcruiseController@index');
	Route::post('api/v1/booking/cruise/create', 'ApiForLoyalty\BookingforcruiseController@create');

	Route::get('api/v1/cruise/', 'ApiForLoyalty\SearchforcruiseController@index');
	Route::post('api/v1/cruise/create', 'ApiForLoyalty\SearchforcruiseController@create');

	Route::get('api/v1/cars/', 'ApiForLoyalty\SearchforcarsController@index');
	Route::post('api/v1/cars/create', 'ApiForLoyalty\SearchforcarsController@create');

	Route::get('api/v1/booking/cars/', 'ApiForLoyalty\BookingforcarsController@index');
	Route::post('api/v1/booking/cars/create', 'ApiForLoyalty\BookingforcarsController@create');

	Route::get('api/v1/flights/', 'ApiForLoyalty\SearchforflightsController@index');
	Route::post('api/v1/flights/create', 'ApiForLoyalty\SearchforflightsController@create');

	Route::get('api/v1/booking/lodging', 'ApiForLoyalty\BookingforlodgingController@index');
	Route::post('api/v1/booking/lodging/create', 'ApiForLoyalty\BookingforlodgingController@create');

	Route::get('api/v1/lodging/', 'ApiForLoyalty\SearchforlodgingController@index');
	Route::post('api/v1/lodging/create', 'ApiForLoyalty\SearchforlodgingController@create');


	Route::get('api/v1/booking/flights', 'ApiForLoyalty\BookingforflightsController@index');
	Route::post('api/v1/booking/flights/create', 'ApiForLoyalty\BookingforflightsController@create');

	Route::put('api/v1/affiliation/{leisure_id}', 'ApiForLoyalty\ApiaffiliationController@getUseraffiliation');
	Route::put('api/v1/affiliation/payment/{leisure_id}', 'ApiForLoyalty\ApiaffiliationController@putUseraffpayment');
	Route::put('api/v1/affiliation/lastpayment/{leisure_id}', 'ApiForLoyalty\ApiaffiliationController@putUserafflastpayment');
	Route::put('api/v1/affiliation/nextpayment/{leisure_id}', 'ApiForLoyalty\ApiaffiliationController@putUseraffnextpayment');
	Route::put('api/v1/affiliation/duepayments/{leisure_id}', 'ApiForLoyalty\ApiaffiliationController@putUseraffduepayment');

	Route::put('api/v1/vacationalfund/{leisure_id}', 'ApiForLoyalty\ApivacationalfundsController@Getmonthlyamount');
	Route::put('api/v1/vacationalfund/lastpayment/{leisure_id}', 'ApiForLoyalty\ApivacationalfundsController@Getlastpayment');
	Route::put('api/v1/vacationalfund/nextpayment/{leisure_id}', 'ApiForLoyalty\ApivacationalfundsController@Getnextpayment');
	Route::put('api/v1/vacationalfund/duepayments/{leisure_id}', 'ApiForLoyalty\ApivacationalfundsController@Getuservacduepayments');
	Route::put('api/v1/vacationalfund/withdraw/{leisure_id}', 'ApiForLoyalty\ApivacationalfundsController@Withdraw');
	Route::put('api/v1/vacationalfund/lastwithdraw/{leisure_id}', 'ApiForLoyalty\ApivacationalfundsController@GetLastWithdrawDate');
	Route::put('api/v1/vacationalfund/currentbalance/{leisure_id}', 'ApiForLoyalty\ApivacationalfundsController@GetCurrentBalance');

	Route::put('api/v1/reservation/usJ7X9B00sNpaoKVtVXrLG8A63PK7HiRC3rmG8SAl02y8ZR1qH', 'ApiForLoyalty\ApiReservationsController@addReservation');

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
	Route::post('payment/bonus', 'PaymentController@bonus');
	
	Route::get('payment/credit-card', 'PaymentController@getAddCreditCard');
	
	
	Route::get('creditcardinfo/update', 'PaymentController@CreditcardinfoUpdate');
	
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
	Route::post('useraccount/credit-payment', 'UseraccountController@creditPayment');
	
	Route::get('useraccount/activation/{code}', 'UseraccountController@activation');
	
	Route::post('codes/check', 'CodesController@check');
	
	Route::post('/language', array(
		'before' => 'csrf',
		'as'    =>  'language-choose',
		'uses'  =>  'LanguageController@choose'
	));
});