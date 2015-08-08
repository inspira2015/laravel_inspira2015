<?php
namespace App\Libraries\PayU\util;
use App\Libraries\PayU;
use App\Libraries\PayU\api\Environment;
use App\Libraries\PayU\api\SupportedLanguages;
use App\Libraries\PayU\api\PayUKeyMapName;
use App\Libraries\PayU\api\PayUCommands;
use App\Libraries\PayU\api\PayUTransactionResponseCode;
use App\Libraries\PayU\api\PayUHttpRequestInfo;
use App\Libraries\PayU\api\PayUResponseCode;
use App\Libraries\PayU\api\PayuPaymentMethodType;
use App\Libraries\PayU\api\PaymentMethods;
use App\Libraries\PayU\api\PayUCountries;
use App\Libraries\PayU\exceptions\PayUErrorCodes;
use App\Libraries\PayU\exceptions\PayUException;
use App\Libraries\PayU\exceptions\ConnectionException;
use App\Libraries\PayU\api\PayUConfig;
use App\Libraries\PayU\api\RequestMethod;
use App\Libraries\PayU\util\SignatureUtil;
use App\Libraries\PayU\api\TransactionType;
use App\Libraries\PayU\util\PayURequestObjectUtil;
use App\Libraries\PayU\util\PayUParameters;
use App\Libraries\PayU\util\CommonRequestUtil;
use App\Libraries\PayU\util\RequestPaymentsUtil;
use App\Libraries\PayU\util\UrlResolver;
use App\Libraries\PayU\util\PayUReportsRequestUtil;
use App\Libraries\PayU\util\PayUTokensRequestUtil;
use App\Libraries\PayU\util\PayUSubscriptionsRequestUtil;
use App\Libraries\PayU\util\PayUSubscriptionsUrlResolver;
use App\Libraries\PayU\util\HttpClientUtil;
use App\Libraries\PayU\util\PayUApiServiceUtil;
use App\Libraries\PayU\PayUBankAccounts;
use App\Libraries\PayU\PayUPayments;
use App\Libraries\PayU\PayUReports;
use App\Libraries\PayU\PayUTokens;
use App\Libraries\PayU\PayUSubscriptions;
use App\Libraries\PayU\PayUCustomers;
use App\Libraries\PayU\PayUSubscriptionPlans;
use App\Libraries\PayU\PayUCreditCards;
use App\Libraries\PayU\PayURecurringBill;
use App\Libraries\PayU\PayURecurringBillItem;
/**
 * Utility class for send http request
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0
*/
class HttpClientUtil {
	
	
	const CONTENT_TYPE = 'Content-Type: application/json; charset=UTF-8';
	
	const ACCEPT = 'Accept: application/json';
	
	const CONTENT_LENGTH =  'Content-Length: ';
	
	const ACCEPT_LANGUAGE = 'Accept-Language: ';
	
	/**
	 * Sends a request type json
	 * @param Object $request this object is encode to json is used to request data
	 * @param PayUHttpRequestInfo $payUHttpRequestInfo object with info to send an api request
	 * @return string response
	 * @throws RuntimeException
	 */
	static function sendRequest($request, PayUHttpRequestInfo $payUHttpRequestInfo){
		
		$httpHeader = array(
		HttpClientUtil::CONTENT_TYPE,
		HttpClientUtil::CONTENT_LENGTH . strlen($request),
		HttpClientUtil::ACCEPT);
		if((isset($payUHttpRequestInfo->lang))){
			array_push($httpHeader,HttpClientUtil::ACCEPT_LANGUAGE . '$payUHttpRequestInfo->lang');
		}
		
		
		$curl = curl_init($payUHttpRequestInfo->getUrl());
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $payUHttpRequestInfo->method);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER,$httpHeader);
		
		if(isset($payUHttpRequestInfo->user) && isset ($payUHttpRequestInfo->password)){
			curl_setopt($curl, CURLOPT_USERPWD, $payUHttpRequestInfo->user . ":" . $payUHttpRequestInfo->password);
		}
		
		$curlResponse = curl_exec($curl);
		
		$httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		if($curlResponse === false && $httpStatus === 0){
			throw new ConnectionException(PayUErrorCodes::CONNECTION_EXCEPTION, 'the url [' . $payUHttpRequestInfo->getUrl() . '] did not respond');
		}
		
 		if ($curlResponse === false) {
 			$requestInfo = http_build_query(curl_getinfo($curl), ' ', ',');
 			$curlMsgError = sprintf(" error occured during curl exec info: curl message[%s], curl error code [%s], curl request details [%s]", 
 					curl_error($curl), curl_errno($curl), $requestInfo);
			
 			curl_close($curl);
 			throw new RuntimeException($curlMsgError);
 		}
		
		curl_close($curl);
		
		if(empty($curlResponse)){
			return $httpStatus;
		}else{
			return $curlResponse;
		}
		
	}
	
}