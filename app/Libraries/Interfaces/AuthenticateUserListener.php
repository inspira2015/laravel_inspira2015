<?php
namespace App\Libraries\Interfaces;


interface AuthenticateUserListener
{
	public function userHasLoggedIn($user);
}