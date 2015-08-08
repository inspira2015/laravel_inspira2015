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
 * Util class to build  the url to subscriptions api operations
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0, 22/12/2013
 *
 */
class PayUSubscriptionsUrlResolver extends UrlResolver{
	
	/** constant to plan entity */
	const PLAN_ENTITY = 'Plan';
	
	/** constant to customer entity */
	const CUSTOMER_ENTITY = 'Customer';
	
	/** constant to credit card entity */
	const CREDIT_CARD_ENTITY = 'CreditCard';
	
	/** constant to bank account entity */
	const BANK_ACCOUNT_ENTITY = 'BankAccount';
	
	/** constant to subscription entity */
	const SUBSCRIPTIONS_ENTITY = 'subscription';
	
	/** constant to recurring bill entity */
	const RECURRING_BILL_ENTITY ='RecurringBill';
	
	/** constant to recurring bill item entity */
	const RECURRING_BILL_ITEM_ENTITY ='RecurringBillItem';
	
	/**
	 * Specifies the verb to find customers by  planId,
	 * planCode with limit and offset
	 */
	const CUSTOMERS_PARAM_SEARCH = "getByParam";	

	/** instancia to singleton pattern*/
	private static $instancia;
	
	/**
	 * the constructor class
	 */
	 private function __construct()
	 {
	 	$planBaseUrl = '/plans';
	 	$planUrlInfo = array(
	 			PayUSubscriptionsUrlResolver::ADD_OPERATION => array('segmentPattern'=> $planBaseUrl, 'numberParams'=> 0),
	 			PayUSubscriptionsUrlResolver::GET_OPERATION => array('segmentPattern'=> $planBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::EDIT_OPERATION => array('segmentPattern'=> $planBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::QUERY_OPERATION => array('segmentPattern'=> $planBaseUrl, 'numberParams'=> 0),	 			
	 			PayUSubscriptionsUrlResolver::DELETE_OPERATION => array('segmentPattern'=> $planBaseUrl . '/%s', 'numberParams'=> 1));
	 	
	 	$customerBaseUrl = '/customers';
	 	$customerUrlInfo = array(
	 			PayUSubscriptionsUrlResolver::ADD_OPERATION => array('segmentPattern'=> $customerBaseUrl, 'numberParams'=> 0),
	 			PayUSubscriptionsUrlResolver::GET_OPERATION => array('segmentPattern'=> $customerBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::EDIT_OPERATION => array('segmentPattern'=> $customerBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::DELETE_OPERATION => array('segmentPattern'=> $customerBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::CUSTOMERS_PARAM_SEARCH => array('segmentPattern'=> $customerBaseUrl, 'numberParams'=> 0));	
	 	
	 	$creditCardBaseUrl = '/creditCards';
	 	$creditCardsUrlInfo = array(
	 			PayUSubscriptionsUrlResolver::ADD_OPERATION => array('segmentPattern'=> $customerBaseUrl .'/%s'.$creditCardBaseUrl, 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::GET_OPERATION => array('segmentPattern'=> $creditCardBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::EDIT_OPERATION => array('segmentPattern'=> $creditCardBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::GET_LIST_OPERATION => array('segmentPattern'=> $customerBaseUrl . '/%s'.$creditCardBaseUrl, 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::DELETE_OPERATION => array('segmentPattern'=> $customerBaseUrl .'/%s'.$creditCardBaseUrl . '/%s/', 'numberParams'=> 2));
	 	
	 	
 		$bankAccountBaseUrl = '/bankAccounts';
 		$bankAccountUrlInfo = array(
 				PayUSubscriptionsUrlResolver::ADD_OPERATION => array('segmentPattern'=> $customerBaseUrl .'/%s'.$bankAccountBaseUrl, 'numberParams'=> 1),
 				PayUSubscriptionsUrlResolver::GET_OPERATION => array('segmentPattern'=> $bankAccountBaseUrl . '/%s', 'numberParams'=> 1),
 				PayUSubscriptionsUrlResolver::QUERY_OPERATION => array('segmentPattern'=> $bankAccountBaseUrl . '/params%s', 'numberParams'=> 1),
 				PayUSubscriptionsUrlResolver::EDIT_OPERATION => array('segmentPattern'=> $bankAccountBaseUrl . '/%s', 'numberParams'=> 1),
 				PayUSubscriptionsUrlResolver::DELETE_OPERATION => array('segmentPattern'=> $customerBaseUrl . '/%s' . $bankAccountBaseUrl . '/%s', 'numberParams'=> 2),
 				PayUSubscriptionsUrlResolver::GET_LIST_OPERATION => array('segmentPattern'=> $customerBaseUrl . '/%s' . $bankAccountBaseUrl, 'numberParams'=> 1));
 		 

	 	$subscriptionsCardBaseUrl = '/subscriptions';
	 	$subscriptionsUrlInfo = array(
	 			PayUSubscriptionsUrlResolver::ADD_OPERATION => array('segmentPattern'=> $subscriptionsCardBaseUrl, 'numberParams'=> 0),
	 			PayUSubscriptionsUrlResolver::GET_OPERATION => array('segmentPattern'=> $subscriptionsCardBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::EDIT_OPERATION => array('segmentPattern'=> $subscriptionsCardBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::DELETE_OPERATION => array('segmentPattern'=> $subscriptionsCardBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::GET_LIST_OPERATION => array('segmentPattern'=> $subscriptionsCardBaseUrl, 'numberParams'=> 0));
	 	
	 	
	 	$recurringBillBaseUrl = '/recurringBill';
	 	$recurringBillUrlInfo = array(
	 			PayUSubscriptionsUrlResolver::GET_OPERATION => array('segmentPattern'=> $recurringBillBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::QUERY_OPERATION => array('segmentPattern'=> $recurringBillBaseUrl, 'numberParams'=> 0));
	 		
	 	
	 	$recurringBillItemBaseUrl = '/recurringBillItems';
	 	$recurringBillItemUrlInfo = array(
	 			PayUSubscriptionsUrlResolver::ADD_OPERATION => array('segmentPattern'=> $subscriptionsCardBaseUrl .'/%s'.$recurringBillItemBaseUrl, 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::GET_OPERATION => array('segmentPattern'=> $recurringBillItemBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::EDIT_OPERATION => array('segmentPattern'=> $recurringBillItemBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::GET_LIST_OPERATION => array('segmentPattern'=> $recurringBillItemBaseUrl, 'numberParams'=> 0),
	 			PayUSubscriptionsUrlResolver::DELETE_OPERATION => array('segmentPattern'=> $recurringBillItemBaseUrl . '/%s', 'numberParams'=> 1));
	 	
	 	
	 	
	 	$this->urlInfo = array( PayUSubscriptionsUrlResolver::PLAN_ENTITY => $planUrlInfo,
								PayUSubscriptionsUrlResolver::CUSTOMER_ENTITY => $customerUrlInfo,
								PayUSubscriptionsUrlResolver::CREDIT_CARD_ENTITY => $creditCardsUrlInfo,
	 							PayUSubscriptionsUrlResolver::SUBSCRIPTIONS_ENTITY => $subscriptionsUrlInfo,
	 							PayUSubscriptionsUrlResolver::RECURRING_BILL_ENTITY => $recurringBillUrlInfo,
	 							PayUSubscriptionsUrlResolver::RECURRING_BILL_ITEM_ENTITY => $recurringBillItemUrlInfo,
	 							PayUSubscriptionsUrlResolver::BANK_ACCOUNT_ENTITY => $bankAccountUrlInfo
	 							);
	 	
	 }
	 
	/**
	 * return a instance of this class
	 * @return PayUSubscriptionsUrlResolver
	 */
	public static function getInstance(){
		if(!self::$instancia instanceof self){
	 		self::$instancia = new self;
	 	}
	 	return self::$instancia;
	 }
	
}