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
 * Util class for WEB request
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0
 * 
 */
class CommonRequestUtil{
	
	
	/**
	 * Add to request object common info to proccess a request
	 * @param string $lang language to be used
	 * @param string $command PayU request command
	 * @return the request with basic information
	 */
	protected static function buildCommonRequest($lang, $command){
		$request = new \stdClass();
		$request->language = $lang;
		$request->command = $command;
		$request->merchant = CommonRequestUtil::buildMerchant();
		$request->test = PayU::$isTest;
		return $request;
	}
	
	/**
	 * Build a merchant to be added to request
	 * @return the merchant built
	 */
	protected static function buildMerchant(){
		$merchant = new \stdClass();
		$merchant->apiLogin = PayU::$apiLogin;
		$merchant->apiKey= PayU::$apiKey;
		return $merchant;
	}
	
	
	
	/**
	 * Adds an entry to the map object the value and key must be not null
	 * @param Object $map
	 * @param string $key the key to entry key
	 * @param string $value the value to the entry value
	 * @return $map whith the valid entry
	 *
	 */
	public static function addMapEntry($map, $key, $value){
	
		if( !isset($map) ){
			$map = new \stdClass();
		}
		
		if(isset($key) && isset($value)){
			$map->$key = $value;
		}
		
		return $map;
	}
	
	
	
	/**
	 * 
	 * Validate if the both required or invalid parameters exist in the parameters array 
	 * @param array $parameters holds the parameters
	 * @param array $required holds the key names of the required parameters
	 * @param array $invalid holds the key names of the invalid parameters 
	 * @throws InvalidParameterException
	 */
	static function validateParameters($parameters,	$required = NULL, $invalid = NULL) {

		$errorMessage = null;
		$isError = false;
				
		if (empty($parameters)) {
			throw new \InvalidArgumentException("Parameters can not be null or empty.");
		}else if(empty($required) && empty($invalid)){
			throw new \InvalidArgumentException(" both the required and invalid parameter are null");
		}else {
			
			if(isset($required)){
				foreach ($required as $r){
					if (!array_key_exists($r,$parameters)
					|| (empty($parameters[$r]) && $parameters[$r] !== FALSE)) {
						$errorMessage = "Parameter [" . $r ."] is required.";
						$isError = true;
					}
				}
			}
			
			if(isset($invalid)){
				foreach ($invalid as $r){
					if (array_key_exists($r,$parameters)) {
						$errorMessage = "Parameter [" . $r ."] is not allowed.";
						$isError = true;
					}
				}
			}
			
		}
	
		if ($isError) {
			throw new \InvalidArgumentException($errorMessage);
		}
	
	}
	
	/**
	* determines whether any parameter key is within the parameters set
	* @param array $parameters holds the parameters
	* @param array $keyNamesSet holds the key names of the set
	* @return true if some parameter is in the set of keys
	*/
	static function isParameterInSet($parameters, $keyNamesSet) {
		$wasFound = false;
		if (!empty($parameters)) {

			if(isset($keyNamesSet)){
				foreach ($keyNamesSet as $key){
					if (array_key_exists($key,$parameters)) {
						$wasFound = true;
						break;
					}
				}
			}			
			
		}
		return $wasFound;
	}	
	
	/**
	 * Returns a parameter value only if is not a empty string null the otherwise
	 * @param array $parameters the parameter array
	 * @param string $index the key in the array
	 * @return string|NULL parameter value only if is not a empty string null the otherwise
	 */
	public static function getParameter($parameters, $index){
		if(isset($parameters[$index])){
			if(is_string($parameters[$index])){
				$parameters[$index] = trim($parameters[$index]);
			}
			
			if(!is_string($parameters[$index]) || $parameters[$index] != ''){
				return $parameters[$index];
			}
		}
		return NULL;
	}
	
	
	/**
	 * Build a basic credit card object to be added to payment request
	 * @param object $parameters with the credit card info
	 * @return the credit card built
	 */
	protected static function buildCreditCard($parameters){
		$creditCard = new \stdClass();
		$creditCard->name = CommonRequestUtil::getParameter($parameters, PayUParameters::PAYER_NAME);
		$creditCard->number = CommonRequestUtil::getParameter($parameters, PayUParameters::CREDIT_CARD_NUMBER);
		$creditCard->expirationDate = CommonRequestUtil::getParameter($parameters, PayUParameters::CREDIT_CARD_EXPIRATION_DATE);
		$creditCard->securityCode = CommonRequestUtil::getParameter($parameters, PayUParameters::CREDIT_CARD_SECURITY_CODE);
		$creditCard->processWithoutCvv2 = (bool) CommonRequestUtil::getParameter($parameters, PayUParameters::PROCESS_WITHOUT_CVV2);
		$creditCard->document = CommonRequestUtil::getParameter($parameters, PayUParameters::CREDIT_CARD_DOCUMENT);
	
		return $creditCard;
	}
	
	
	/**
	 * Validates a date string whit the payments date format
	 *
	 * @param string $dateString
	 * @param string $dateFormat
	 * @param string $parameterName the name of the parameter
	 * @throws InvalidArgumentException
	 * @return boolean true if is valid or exception the otherwise
	 */
	protected static function isValidDate( $dateString, $dateFormat, $parameterName){
		if (\DateTime::createFromFormat($dateFormat, $dateString) == FALSE) {
			throw new
			\InvalidArgumentException(
					sprintf("The [%s] format is invalid. Use [%s] ",
							$parameterName,
							$dateFormat));
		}
		return true;
	}
	
	
	/**
	 * Adds the attributes of params as "@QueryParms" to the given url
	 * 
	 * @param string $url the base url
	 * @param string $params a stdClass containing the params to be added
	 * 
	 * @return the url with the params appended to it
	 */
	public static function addQueryParamsToUrl($url, $params){
		if(isset($params) && $params != null) {
			$query = http_build_query($params);
			$url = $url . "?" . $query;
		}
		return $url;
	}	
	
}


