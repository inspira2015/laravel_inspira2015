<?php
namespace App\Libraries\PayU\util;
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
 * Utility class to generate the payu signature
 * 
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 17/10/2013
 *
 */
 class SignatureUtil{
	
	/** MD5 algorithm used */
	const MD5_ALGORITHM = "md5";
	
	/** SHA algorithm used */
	const  SHA_ALGORITHM = "sha";
	
	/** Decimal format with no decimals */
	const DECIMAL_POINT = ".";
	/** Decimal format with one decimal */
	const THOUSANDS_SEPARATOR = "";
	/** Decimal format with two decimals */
	const DECIMALS = 0;
	
	
	
	
	/**
	 * 
	 * @param Object $order the order to be sent in a transaction request
	 * @param string $merchantId the identifier of merchant
	 * @param string $key authentication key
	 * @param string $algorithm the to use
	 * @throws IllegalArgumentException
	 * @return the signature built
	 */
	static function buildSignature($order,$merchantId, $key, $algorithm){
		
		$message = SignatureUtil::buildMessage($order, $merchantId, $key);
		
		if (SignatureUtil::MD5_ALGORITHM == $algorithm) {
			return md5($message);
		}else if (SignatureUtil::SHA_ALGORITHM == $algorithm) {
			return sha1($message);
		}else {
			throw new InvalidArgumentException("Could not create signature. Invalid algoritm");
		}
		
		
	}
	
	
	/**
	 * Build a plain signature
	 * @param Object $order the order to be sent in a transaction request
	 * @param string $merchantId the identifier of merchant
	 * @param string $key authentication key
	 * @return the plain message
	 */
	static function buildMessage($order, $merchantId, $key){
		SignatureUtil::validateOrder($order, $merchantId);
		$txValueName = PayUKeyMapName::TX_VALUE;
		$referenceCode = $order->referenceCode; 
		$value = $order->additionalValues->$txValueName->value;
		
		$floatValue = floatval($value);
		$valueRounded = round($floatValue, SignatureUtil::DECIMALS, PHP_ROUND_HALF_EVEN); 
		$valueFormatted = number_format($valueRounded,SignatureUtil::DECIMALS,
										SignatureUtil::DECIMAL_POINT,
										SignatureUtil::THOUSANDS_SEPARATOR);
		$currency = $order->additionalValues->$txValueName->currency;
		
		
		$message = $key . '~' . $merchantId . '~' . $referenceCode . '~' . $valueFormatted . '~' . $currency;

		return $message;
	}
	
	
	/**
	 * Validates the order values before to create a request signature
	 * @param Object $order the order to be sent in a transaction request
	 * @param string $merchantId the identifier of merchant
	 * @throws InvalidArgumentException
	 */
	static function validateOrder($order, $merchantId){
		$txValueName = PayUKeyMapName::TX_VALUE;
		if (!isset($merchantId)) {
			
			throw new InvalidArgumentException("The merchant id may not be null");
			
		} else if (!isset($order->referenceCode)) {
			
			throw new InvalidArgumentException("The reference code may not be null");
			
		} else if (!isset($order->additionalValues->$txValueName)) {
			
			throw new InvalidArgumentException("The order additional value TX_VALUE may not be null");
			
		} else if (!isset($order->additionalValues->$txValueName->currency)) {
			
			throw new InvalidArgumentException("The order currency may not be null");
			
		} else if (!isset($order->additionalValues->$txValueName->value)){
			
			throw new InvalidArgumentException("The order value may not be null");
			
		}
	}
}