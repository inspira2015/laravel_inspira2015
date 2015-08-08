<?php
namespace App\Libraries\PayU\api;
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
 * This class helps to build the request api info 
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 29/10/2013
 *
 */
class PayUHttpRequestInfo{
	
	/** the http method to the request */
	var $method;
	
	/** the environment to the request*/
	var $environment;
	
	/** the segment to add the url to the request*/
	var $segment;
	
	/** the user for Basic Http authentication */
	var $user;
	
	/** the password for Basic Http authentication */
	var $password;
	
	/** the language to be include in the header request */
	var $lang;
	
	
	
	/**
	 * 
	 * @param string $environment
	 * @param string $method
	 * @param string $segment
	 */
	function __construct($environment, $method, $segment = null) {
		$this->environment = $environment;
		$this->method = $method;
		$this->segment = $segment;
	}
	
	
	/**
	 * Builds the url for the environment selected
	 */
	public function getUrl(){
		if(isset($this->segment)){
			return Environment::getApiUrl($this->environment) . $this->segment;
		}else{
			return Environment::getApiUrl($this->environment);
		}
	}
	
	
	
}