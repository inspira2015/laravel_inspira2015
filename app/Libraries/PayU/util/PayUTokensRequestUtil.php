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
 * Utility class to process parameters and send token requests
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 31/10/2013
 *
 */

class PayUTokensRequestUtil extends CommonRequestUtil{
	
	
	/**
	 * Builds a create credit card token request
	 *
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return the request built
	 * 
	 */
	public static function buildCreateTokenRequest($parameters, $lang = null){
		
		if(!isset($lang)){
			$lang = PayU::$language;
		}

		$request = CommonRequestUtil::buildCommonRequest($lang,
				PayUCommands::CREATE_TOKEN);
		
		$request->creditCardToken = PayUTokensRequestUtil::buildCreditCardToken($parameters);
		
		return $request;
	}
	

	/**
	 * Builds a create credit card token request
	 *
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return the request built
	 */
	public static function buildGetCreditCardTokensRequest($parameters,$lang){
		
		if(!isset($lang)){
			$lang = PayU::$language;
		}
		
		$request = CommonRequestUtil::buildCommonRequest($lang,
				PayUCommands::GET_TOKENS);
		
		$creditCardTokenInformation = new \stdClass();
		$creditCardTokenInformation->creditCardTokenId = CommonRequestUtil::getParameter($parameters, PayUParameters::TOKEN_ID);
		$creditCardTokenInformation->payerId = CommonRequestUtil::getParameter($parameters, PayUParameters::PAYER_ID);
		
		
		$startDate = CommonRequestUtil::getParameter($parameters, PayUParameters::START_DATE);
		if($startDate != null && CommonRequestUtil::isValidDate($startDate,PayUConfig::PAYU_DATE_FORMAT, PayUParameters::EXPIRATION_DATE)){
			$creditCardTokenInformation->startDate = $startDate;
		}
		
		$endDate = CommonRequestUtil::getParameter($parameters, PayUParameters::END_DATE);
		if($endDate != null && CommonRequestUtil::isValidDate($endDate,PayUConfig::PAYU_DATE_FORMAT, PayUParameters::EXPIRATION_DATE)){
			$creditCardTokenInformation->endDate = $endDate;
		}
		
		$request->creditCardTokenInformation =  $creditCardTokenInformation;

		return $request;
	}
	
	
	/**
	 * Builds a create credit card token remove request
	 *
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return the request built
	 */
	public static function buildRemoveTokenRequest($parameters,$lang){
		
		if(!isset($lang)){
			$lang = PayU::$language;
		}
		
		$request = CommonRequestUtil::buildCommonRequest($lang,
				PayUCommands::REMOVE_TOKEN);
		
		$removeCreditCardToken = new \stdClass();
		
		$removeCreditCardToken->creditCardTokenId = CommonRequestUtil::getParameter($parameters, PayUParameters::TOKEN_ID);
		$removeCreditCardToken->payerId = CommonRequestUtil::getParameter($parameters, PayUParameters::PAYER_ID);
		
		$request->removeCreditCardToken = $removeCreditCardToken;
		
		return $request;
	}
		
	
	/**
	 * Builds a credit card token to be added to request
	 * @param array $parameters
	 * @return the credit card token built
	 */
	private static function buildCreditCardToken($parameters){

		$creditCardToken = new \stdClass();
		
		$creditCardToken->name = CommonRequestUtil::getParameter($parameters, PayUParameters::PAYER_NAME);
		$creditCardToken->payerId = CommonRequestUtil::getParameter($parameters, PayUParameters::PAYER_ID);
		$creditCardToken->identificationNumber = CommonRequestUtil::getParameter($parameters, PayUParameters::PAYER_DNI);
		$creditCardToken->paymentMethod = CommonRequestUtil::getParameter($parameters, PayUParameters::PAYMENT_METHOD);
		$creditCardToken->expirationDate = CommonRequestUtil::getParameter($parameters, PayUParameters::CREDIT_CARD_EXPIRATION_DATE);
		$creditCardToken->number = CommonRequestUtil::getParameter($parameters, PayUParameters::CREDIT_CARD_NUMBER);
		$creditCardToken->document = CommonRequestUtil::getParameter($parameters, PayUParameters::CREDIT_CARD_DOCUMENT);
		
		return $creditCardToken;
		
	}
	
	
}