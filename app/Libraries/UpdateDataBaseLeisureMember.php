<?php

namespace App\Libraries;
use App\Model\Dao\UserDao;
use App\Model\Entity\UserAffiliation;

class UpdateDataBaseLeisureMember extends CreateLeisureLoyaltyUser
{
	protected $userDao;

	public function __construct(UserDao $userDao, UserAffiliation $userAffiliation)
	{
		parent::__construct(  $userAffiliation );
		$this->userDao = $userDao;
	}

	protected function checkLeisure()
	{
		$memberId = $this->createOrRetriveMemberId();
		if( $memberId == FALSE )
		{
			return FALSE;
		}

		$this->userDao->load( $this->objUser->id ); 
		$this->userDao->leisure_id  = $memberId;
		$this->userDao->save();
		return TRUE;
	}


	public function saveMemberId()
	{
		return $this->checkLeisure();
	}



}