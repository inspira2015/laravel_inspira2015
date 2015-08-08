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
 * Util class to build the url to api operations
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0, 16/09/2014
 *
 */
abstract class UrlResolver{
	
	/** constant to add operation */
	const ADD_OPERATION = "add";
	
	/** constant to edit operation */
	const EDIT_OPERATION = "edit";
	
	/** constant to delete operation */
	const DELETE_OPERATION = "delete";
	
	/** constant to get operation */
	const GET_OPERATION = "get";
	
	/** constant to query operation */
	const QUERY_OPERATION = "query";
	
	/** constant to get list operation */
	const GET_LIST_OPERATION = "getList";	
	
	/** contains the url info to each entity and operation this is built in the constructor class */
	protected $urlInfo;
	
	/**
	 * build an url segment using the entity, operation and the url params
	 * @param string $entity
	 * @param string $operation
	 * @param string $params
	 * @throws InvalidArgumentException
	 * @return the url segment built
	 */
	public function getUrlSegment($entity, $operation, $params = NULL){
	
		if(!isset($this->urlInfo[$entity])){
			throw new InvalidArgumentException("the entity " . $entity. 'was not found ');
		}
	
		if(!isset($this->urlInfo[$entity][$operation])){
			throw new InvalidArgumentException("the request method " . $requestMethod. 'was not found ');
		}
	
		$numberParams = $this->urlInfo[$entity][$operation]['numberParams'];
	
		if(!isset($params) && $numberParams > 0){
			throw new InvalidArgumentException("the url needs " . $numberParams. ' parameters ');
		}
	
		if(isset($params) && count($params) != $numberParams){
			throw new InvalidArgumentException("the url needs " . $numberParams. ' parameters  but ' . count($params) . 'was received');
		}
	
		if(!is_array($params)){
			$params = array($params);
		}
	
		return vsprintf($this->urlInfo[$entity][$operation]['segmentPattern'],$params);
	
	}	
	
}
