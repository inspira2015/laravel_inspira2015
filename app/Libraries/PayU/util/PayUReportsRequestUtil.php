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
//use App\Libraries\PayU\util\CommonRequestUtil;
use App\Libraries\PayU\util\RequestPaymentsUtil;
use App\Libraries\PayU\util\UrlResolver;
//use App\Libraries\PayU\util\PayUReportsRequestUtil;
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
 * Utility class to process parameters and send reports requests
 *
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 29/10/2013
 *
 */

class PayUReportsRequestUtil extends CommonRequestUtil{
	
	
	/**
	 * Build a ping request
	 * @param string $lang language to be used
	 * @return the ping request built
	 */
	static function buildPingRequest($lang=null){
	
		if(!isset($lang)){
			$lang = PayU::$language;
		}
	
		$request = CommonRequestUtil::buildCommonRequest($lang,
				PayUCommands::PING);
	
		return $request;
	}
	
	
	/**
	 * Builds an order details reporting request. The order will be query by id
	 *
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return the request built
	 */
	public static function buildOrderReportingDetails($parameters, $lang=null){
		
		if(!isset($lang)){
			$lang = PayU::$language;
		}
		
		$request = CommonRequestUtil::buildCommonRequest($lang,
				PayUCommands::ORDER_DETAIL);
		
		$orderId = intval(CommonRequestUtil::getParameter($parameters, PayUParameters::ORDER_ID));
		
		
		$request->details = CommonRequestUtil::addMapEntry(null, PayUKeyMapName::ORDER_ID, $orderId); 
		
		return $request;
	}
	
	

	
	/**
	 * Builds an order details reporting request. The order will be query by reference code
	 *
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return the request built
	 * 
	 */
	public static function buildOrderReportingByReferenceCode($parameters, $lang=null) {
	
		if(!isset($lang)){
			$lang = PayU::$language;
		}
		
		$request = CommonRequestUtil::buildCommonRequest($lang,
				PayUCommands::ORDER_DETAIL_BY_REFERENCE_CODE);
		
		$referenceCode = CommonRequestUtil::getParameter($parameters, PayUParameters::REFERENCE_CODE);
		
		$request->details = CommonRequestUtil::addMapEntry(null, PayUKeyMapName::REFERENCE_CODE, $referenceCode);
	
		return $request;
	}
	

	/**
	 * Builds a transaction reporting request the transaction will be query by id
	 *
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The complete reporting request to be sent to the server
	 */
	public static function buildTransactionResponse($parameters, $lang=null) {

		if(!isset($lang)){
			$lang = PayU::$language;
		}
		
		$request = CommonRequestUtil::buildCommonRequest($lang,
				PayUCommands::TRANSACTION_RESPONSE_DETAIL);
		
		$transactionId = CommonRequestUtil::getParameter($parameters, PayUParameters::TRANSACTION_ID);
		
		$request->details = CommonRequestUtil::addMapEntry(null, PayUKeyMapName::TRANSACTION_ID, $transactionId);
	
		return $request;
	}
	
	
}