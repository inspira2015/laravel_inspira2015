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
 * 
 * Util class to send request and process the response 
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0 
 *
 */
class PayUApiServiceUtil{
	
	
	/**
	 * Sends a request type json 
	 * 
	 * @param Object $request this object is encode to json is used to request data
	 * @param PayUHttpRequestInfo $payUHttpRequestInfo object with info to send an api request
	 * @param bool $removeNullValues if remove null values in request and response object 
	 * @return string response
	 * @throws RuntimeException
	 */
	public static function sendRequest($request, PayUHttpRequestInfo $payUHttpRequestInfo, $removeNullValues = NULL){
		if(!isset($removeNullValues)){
			$removeNullValues = PayUConfig::REMOVE_NULL_OVER_REQUEST;
		}
		
		if($removeNullValues && $request != null){
			$request = PayURequestObjectUtil::removeNullValues($request);
		}
		
		if($request != NULL){
			$request = PayURequestObjectUtil::encodeStringUtf8($request);
		}
		
		
 		if(isset($request->transaction->order->signature)){
 			$request->transaction->order->signature = 
 			SignatureUtil::buildSignature($request->transaction->order, PayU::$merchantId, PayU::$apiKey, SignatureUtil::MD5_ALGORITHM);
 		}
		
		$requestJson = json_encode($request);
		
		$responseJson = HttpClientUtil::sendRequest($requestJson, $payUHttpRequestInfo);
		
		if( $responseJson == 200 || $responseJson == 204){
			return true;
		}else{
			$response = json_decode($responseJson);
			if(!isset($response)){
				throw new PayUException(PayUErrorCodes::JSON_DESERIALIZATION_ERROR,sprintf(' Error decoding json. Please verify the json structure received. the json isn\'t added in this message '.
						' for security reasons please verify the variable $responseJson on class PayUApiServiceUtil'));
			}
			
			if($removeNullValues){
				$response = PayURequestObjectUtil::removeNullValues($response);
			}
			
			$response = PayURequestObjectUtil::formatDates($response);
			
			if($payUHttpRequestInfo->environment === Environment::PAYMENTS_API || $payUHttpRequestInfo->environment === Environment::REPORTS_API){
				if(PayUResponseCode::SUCCESS == $response->code){
					return $response;
				}else{
					throw new PayUException(PayUErrorCodes::API_ERROR, $response->error);
				}
			}else if($payUHttpRequestInfo->environment === Environment::SUBSCRIPTIONS_API){
				if(!isset($response->type) || ($response->type != 'BAD_REQUEST' && $response->type != 'NOT_FOUND' && $response->type != 'MALFORMED_REQUEST')){
					return $response;
				}else{
					throw new PayUException(PayUErrorCodes::API_ERROR, $response->description);
				}
			}
				
		}
	}
}

