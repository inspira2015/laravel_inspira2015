<?php

require_once 'PayU.php';





class StartPayUInspira extends PayU
{
	
	public function __construct()
	{
		parent::__construct();

	}


	public static function setTestEnv()
	{
		parent::$apiKey = "6u39nqhq8ftd0hlvnjfs66eh8c";
		self::$apiLogin = "11959c415b33d0c";
		self::$merchantId = "500238";
		self::$language = SupportedLanguages::ES;
		self::$isTest = TRUE;
			Environment::validate();
	}





}