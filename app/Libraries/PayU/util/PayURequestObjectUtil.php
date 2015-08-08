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
 * This class has utility methods for objects used in the request
 *  
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0
 */
class PayURequestObjectUtil{
	
	/**
	 * Remove null values of object or array
	 * @param Object $object parameter with null values
	 * @throws InvalidArgumentException if the object parameter is null
	 * @return the object processed
	 */
	public static function removeNullValues($object){
		
		if(!isset($object)){
			throw new InvalidArgumentException("the object to remove null values is null ");
		}
		
		if(!is_object($object) && !is_array($object)){
			throw new InvalidArgumentException("the parameter is not a object or array");
		}
		
		if(is_object($object)){
			foreach($object as $k => $v){
				if($v === null){
					unset($object->$k);
				}else if(is_object($object->$k) || is_array($object->$k)){
					$tempObject = PayURequestObjectUtil::removeNullValues($object->$k);
					if(!isset($tempObject)){
						unset($object->$k);
					}else{
						$object->$k = $tempObject;
					}
					
				}
			}
		}else if(is_array($object)){
			foreach($object as $k => $v){
				if($v === null){
					unset($object[$k]);
				}else if(is_object($object[$k]) || is_array($object[$k])){
					$tempObject = PayURequestObjectUtil::removeNullValues($object[$k]);
					if(!isset($tempObject)){
						unset($object[$k]);
					}else{
						$object[$k] = $tempObject;
					}
						
				}
			}
		}
		
		if(count((array)$object) === 0){
			return null;
		}else{
			return $object;
		}
	}
	
	
	/**
	 * Convert to utf-8 the string values
	 * @param Object or array $object parameter with string values 
	 * @throws InvalidArgumentException if the object parameter is null or it isn't a object
	 * @return the object processed 
	 */
	public static function encodeStringUtf8($object){
		if(!isset($object)){
			throw new InvalidArgumentException("the object to enconde  is null ");
		}
		
		if(!is_object($object) && !is_array($object)){
			throw new InvalidArgumentException("the parameter is not a object or array");
		}
		
		if(is_object($object)){
			foreach($object as $k => $v){
				if($v != null && is_string($v)  && mb_detect_encoding($v,'UTF-8') != 'UTF-8'){
					$object->$k = utf8_encode($v);
				}else if(is_object($object->$k)){
					$object->$k = PayURequestObjectUtil::encodeStringUtf8($object->$k);
				}
			}
		}else if(is_array($object)){
			foreach($object as $k => $v){
				if($v != null && is_string($v)  && mb_detect_encoding($v,'UTF-8') != 'UTF-8'){
					$object[$k] = utf8_encode($v); 
				}else if(is_object($object[$k]) || is_array($object[$k])){
					$object[$k] = PayURequestObjectUtil::encodeStringUtf8($object[$k]);
				}
			}
		}
		
		return $object;
	}
	
	/**
	 * Adjust miliseconds from epoch to date format 
	 * @param the object or array $data
	 * @throws InvalidArgumentException
	 * @return the object or array processed
	 */
	public static function formatDates($data){
		if(!isset($data)){
			throw new InvalidArgumentException("the object to format dates is null ");
		}
		
		if(!is_object($data) && !is_array($data) ){
			throw new InvalidArgumentException("the parameter to format dates is not a object or array");
		}
		
		
		
		foreach($data as $k => $v){
			if(PayURequestObjectUtil::isKeyDateField($k)){
				if(is_array($data)){
					$miliseconds = $data[$k];
					$data[$k] = PayURequestObjectUtil::getDate($miliseconds); 
				}else if(is_object($data)){
					$miliseconds = $data->$k;
					$data->$k = PayURequestObjectUtil::getDate($miliseconds);
				}
			}else if(is_object($data) && (is_object($data->$k) || is_array($data->$k))){
				$data->$k = PayURequestObjectUtil::formatDates($data->$k);
			}else if(is_array($data) && (is_object($data[$k]) || is_array($data[$k]))){
				$data[$k] =  PayURequestObjectUtil::formatDates($data[$k]);
			}
		}
		
		return $data;
	}
	
	/**
	 * Validates if the key in the object belows a date field
	 * @param string $key the field name
	 * @return boolean true if the key field is in the data fields name false the otherwise
	 */
	private static function isKeyDateField($key){
		$dateFields = array('EXPIRATION_DATE', 
							'operationDate',
							'currentPeriodStart', 
							'currentPeriodEnd',
							'dateCharge');

		foreach($dateFields as $field){
			if($field === $key){
				return true;
			}			
		}
		
		return false;
	}
	
	/**
	 * Format a integer to a date string using PayUConfig::PAYU_DATE_FORMAT
	 * @param integer $miliseconds
	 * @throws InvalidArgumentException
	 * @return the date string
	 */
	public static function getDate($miliseconds){
		$formattedValue = floatval($miliseconds);
		if($formattedValue == 0 || $formattedValue == 1){
			throw new InvalidArgumentException("the value in miliseconds for date is invalid");
		}
		
		$seconds = round($formattedValue/1000);
		return date(PayUConfig::PAYU_DATE_FORMAT, $seconds);
	}
	
}