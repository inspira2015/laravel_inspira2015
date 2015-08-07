<?php

namespace App\Libraries;
use App\Libraries\PayU\api\Environment;



//require_once dirname(__FILE__).'/PayU/api/SupportedLanguages.php';
use App\Libraries\PayU\api\SupportedLanguages;
//require_once dirname(__FILE__).'/PayU/api/PayUKeyMapName.php';
use App\Libraries\PayU\api\PayUKeyMapName;
//require_once dirname(__FILE__).'/PayU/api/PayUCommands.php';
use App\Libraries\PayU\api\PayUCommands;
//require_once dirname(__FILE__).'/PayU/api/PayUTransactionResponseCode.php';
use App\Libraries\PayU\api\PayUTransactionResponseCode;
//require_once dirname(__FILE__).'/PayU/api/PayUHttpRequestInfo.php';
use App\Libraries\PayU\api\PayUHttpRequestInfo;
//require_once dirname(__FILE__).'/PayU/api/PayUResponseCode.php';
use App\Libraries\PayU\api\PayUResponseCode;
//require_once dirname(__FILE__).'/PayU/api/PayuPaymentMethodType.php';
use App\Libraries\PayU\api\PayuPaymentMethodType;
//require_once dirname(__FILE__).'/PayU/api/PaymentMethods.php';
use App\Libraries\PayU\api\PaymentMethods;
//require_once dirname(__FILE__).'/PayU/api/PayUCountries.php';
use App\Libraries\PayU\api\PayUCountries;
//require_once dirname(__FILE__).'/PayU/exceptions/PayUErrorCodes.php';
use App\Libraries\PayU\exceptions\PayUErrorCodes;
//require_once dirname(__FILE__).'/PayU/exceptions/PayUException.php';
use App\Libraries\PayU\exceptions\PayUException;
//require_once dirname(__FILE__).'/PayU/exceptions/ConnectionException.php';
use App\Libraries\PayU\exceptions\ConnectionException;
//require_once dirname(__FILE__).'/PayU/api/PayUConfig.php';
use App\Libraries\PayU\api\PayUConfig;
//require_once dirname(__FILE__).'/PayU/api/RequestMethod.php';
use App\Libraries\PayU\api\RequestMethod;
//require_once dirname(__FILE__).'/PayU/util/SignatureUtil.php';
use App\Libraries\PayU\util\SignatureUtil;
//require_once dirname(__FILE__).'/PayU/api/PaymentMethods.php';
//use App\Libraries\PayU\api\PaymentMethods;
//require_once dirname(__FILE__).'/PayU/api/TransactionType.php';
use App\Libraries\PayU\api\TransactionType;
//require_once dirname(__FILE__).'/PayU/util/PayURequestObjectUtil.php';
use App\Libraries\PayU\util\PayURequestObjectUtil;
//require_once dirname(__FILE__).'/PayU/util/PayUParameters.php';
use App\Libraries\PayU\util\PayUParameters;
//require_once dirname(__FILE__).'/PayU/util/CommonRequestUtil.php';
use App\Libraries\PayU\util\CommonRequestUtil;
//require_once dirname(__FILE__).'/PayU/util/RequestPaymentsUtil.php';
use App\Libraries\PayU\util\RequestPaymentsUtil;
//require_once dirname(__FILE__).'/PayU/util/UrlResolver.php';
use App\Libraries\PayU\util\UrlResolver;
//require_once dirname(__FILE__).'/PayU/util/PayUReportsRequestUtil.php';
use App\Libraries\PayU\util\PayUReportsRequestUtil;
//require_once dirname(__FILE__).'/PayU/util/PayUTokensRequestUtil.php';
use App\Libraries\PayU\util\PayUTokensRequestUtil;
//require_once dirname(__FILE__).'/PayU/util/PayUSubscriptionsRequestUtil.php';
use App\Libraries\PayU\util\PayUSubscriptionsRequestUtil;
//require_once dirname(__FILE__).'/PayU/util/PayUSubscriptionsUrlResolver.php';
use App\Libraries\PayU\util\PayUSubscriptionsUrlResolver;
//require_once dirname(__FILE__).'/PayU/util/HttpClientUtil.php';
use App\Libraries\PayU\util\HttpClientUtil;
//require_once dirname(__FILE__).'/PayU/util/PayUApiServiceUtil.php';
use App\Libraries\PayU\util\PayUApiServiceUtil;
//require_once dirname(__FILE__).'/PayU/api/Environment.php';

//require_once dirname(__FILE__).'/PayU/PayUBankAccounts.php';
use App\Libraries\PayU\PayUBankAccounts;
//require_once dirname(__FILE__).'/PayU/PayUPayments.php';
use App\Libraries\PayU\PayUPayments;
//require_once dirname(__FILE__).'/PayU/PayUReports.php';
use App\Libraries\PayU\PayUReports;
//require_once dirname(__FILE__).'/PayU/PayUTokens.php';
use App\Libraries\PayU\PayUTokens;
//require_once dirname(__FILE__).'/PayU/PayUSubscriptions.php';
use App\Libraries\PayU\PayUSubscriptions;
//require_once dirname(__FILE__).'/PayU/PayUCustomers.php';
use App\Libraries\PayU\PayUCustomers;
//require_once dirname(__FILE__).'/PayU/PayUSubscriptionPlans.php';
use App\Libraries\PayU\PayUSubscriptionPlans;

//require_once dirname(__FILE__).'/PayU/PayUCreditCards.php';
use App\Libraries\PayU\PayUCreditCards;

//require_once dirname(__FILE__).'/PayU/PayURecurringBill.php';
use App\Libraries\PayU\PayURecurringBill;

//require_once dirname(__FILE__).'/PayU/PayURecurringBillItem.php';
use App\Libraries\PayU\PayURecurringBillItem;







/**
 *
 * Holds basic request information
 * 
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 20/10/2013
 *
 */
abstract class PayU {
	
	/**
	 * Api version
	 */
	const  API_VERSION = "4.0.1";

	/**
	 * Api name
	 */
	const  API_NAME = "PayU SDK";
	
	
	const API_CODE_NAME = "PAYU_SDK";

	/**
	 * The method invocation is for testing purposes
	 */
	public static $isTest = false;

	/**
	 * The merchant API key
	 */
	public static  $apiKey = null;

	/**
	 * The merchant API Login
	 */
	public static  $apiLogin = null;

	/**
	 * The merchant Id
	 */
	public static  $merchantId = null;

	/**
	 * The request language
	 */
	public static $language = SupportedLanguages::ES;
	

}


/** validates Environment before begin any operation */
	Environment::validate();


