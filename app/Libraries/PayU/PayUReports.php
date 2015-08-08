<?php
namespace App\Libraries\PayU;
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
 * Manages all PayU reports operations
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 17/10/2013
 * 
 */
class PayUReports{
	
	
	/**
	 * Makes a ping request
	 * @param string $lang language of request see SupportedLanguages class
	 * @throws PayUException 
	 * @return The response to the ping request sent
	 */ 	
	public static function doPing($lang = null) {
		
		$payUHttpRequestInfo = new PayUHttpRequestInfo(Environment::REPORTS_API,RequestMethod::POST);
		 
		return PayUApiServiceUtil::sendRequest(PayUReportsRequestUtil::buildPingRequest(),$payUHttpRequestInfo);	
	}
	
	
	/**
	 * Makes an order details reporting petition by the id
	 *
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return order found
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function getOrderDetail($parameters, $lang = null){
	
		CommonRequestUtil::validateParameters($parameters, array(PayUParameters::ORDER_ID));
		
		$request = PayUReportsRequestUtil::buildOrderReportingDetails($parameters, $lang);
		
		$payUHttpRequestInfo = new PayUHttpRequestInfo(Environment::REPORTS_API,RequestMethod::POST);
		
		$response = PayUApiServiceUtil::sendRequest($request, $payUHttpRequestInfo);
		
		if(isset($response) && isset($response->result)){
			return $response->result->payload;
		}
		
		return null;
		
	}
	
	/**
	 * Makes an order details reporting petition by reference code
	 *
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The order list corresponding whit the given reference code
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function getOrderDetailByReferenceCode($parameters, $lang = null){
		
		CommonRequestUtil::validateParameters($parameters, array(PayUParameters::REFERENCE_CODE));
		
		$request = PayUReportsRequestUtil::buildOrderReportingByReferenceCode($parameters, $lang);
		
		$payUHttpRequestInfo = new PayUHttpRequestInfo(Environment::REPORTS_API,RequestMethod::POST);
		
		$response = PayUApiServiceUtil::sendRequest($request, $payUHttpRequestInfo);
		
		if(isset($response) && isset($response->result)){
			return $response->result->payload;
		}else{
			throw new PayUException(PayUErrorCodes::INVALID_PARAMETERS, "the reference code doesn't exist ");
		}
		
	}
	
	/**
	 * Makes a transaction reporting petition by the id
	 *
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The transaction response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function getTransactionResponse($parameters, $lang = null){
	
		CommonRequestUtil::validateParameters($parameters, array(PayUParameters::TRANSACTION_ID));
		
		$request = PayUReportsRequestUtil::buildTransactionResponse($parameters, $lang);
		
		$payUHttpRequestInfo = new PayUHttpRequestInfo(Environment::REPORTS_API,RequestMethod::POST);
		
		$response = PayUApiServiceUtil::sendRequest($request, $payUHttpRequestInfo);
		
		if(isset($response) && isset($response->result)){
			return $response->result->payload;
		}
		
		return null;
		
	}
}