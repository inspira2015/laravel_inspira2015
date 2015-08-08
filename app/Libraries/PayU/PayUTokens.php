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
 * Manages all PayU tokens operations 
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 31/10/2013
 *
 */
class PayUTokens{
	
	/**
	 * Creates a credit card token
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The transaction response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function create($parameters, $lang = null){
	
		$required = array(PayUParameters::CREDIT_CARD_NUMBER,
						  PayUParameters::PAYER_NAME,
						  PayUParameters::PAYMENT_METHOD,
						  PayUParameters::PAYER_ID,
						  PayUParameters::CREDIT_CARD_EXPIRATION_DATE);
		
		CommonRequestUtil::validateParameters($parameters, $required);		
		
		$request = PayUTokensRequestUtil::buildCreateTokenRequest($parameters,$lang);
		$payUHttpRequestInfo = new PayUHttpRequestInfo(Environment::PAYMENTS_API, RequestMethod::POST);
		return PayUApiServiceUtil::sendRequest($request, $payUHttpRequestInfo);
	}
	
	
	/**
	 * Finds a credit card token
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The transaction response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function find($parameters, $lang = null){
		
		$tokenId = CommonRequestUtil::getParameter($parameters, PayUParameters::TOKEN_ID);
		$required = null;
		
		if($tokenId == null){
			$required = array(PayUParameters::START_DATE, PayUParameters::END_DATE);
		}else{
			$required = array(PayUParameters::TOKEN_ID);
		}
	
		CommonRequestUtil::validateParameters($parameters, $required);
		
		$request = PayUTokensRequestUtil::buildGetCreditCardTokensRequest($parameters,$lang);
		$payUHttpRequestInfo = new PayUHttpRequestInfo(Environment::PAYMENTS_API,RequestMethod::POST);
		return PayUApiServiceUtil::sendRequest($request, $payUHttpRequestInfo);
		
	}
	
	/**
	 * Removes a credit card token
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The transaction response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function remove($parameters, $lang=null){
		
		$required = array(PayUParameters::TOKEN_ID,
							PayUParameters::PAYER_ID);
		
		CommonRequestUtil::validateParameters($parameters, $required);
		
		$request = PayUTokensRequestUtil::buildRemoveTokenRequest($parameters,$lang);
		
		$payUHttpRequestInfo = new PayUHttpRequestInfo(Environment::PAYMENTS_API,RequestMethod::POST);
		return PayUApiServiceUtil::sendRequest($request, $payUHttpRequestInfo);
		
	}
	
}