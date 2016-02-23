<?php
namespace App\Libraries;


use Illuminate\Contracts\Auth\Guard as Auth;
use Laravel\Socialite\Contracts\Factory as Socialite; 
use App\Model\Dao\UserDao;
// use Socialize;
use App\Libraries\Interfaces\AuthenticateUserListener;
use Session;

class CreateUserWithFacebook
{
	private $users;
	private $socialite;
	private $auth;

	public function __construct(UserDao $user,Socialite $socialite, Auth $auth)
	{
		$this->users = $user;
		$this->socialite = $socialite;
		$this->auth = $auth;
	}

	public function execute($hasCode, AuthenticateUserListener $listener)
	{
		if ( ! $hasCode )
		{
			return $this->getAuthorizationFirst();
		}

		$fbUser = $this->getFacebookUser();
		$user = $this->users->getByFacebookId( $fbUser );
		
		if ( $user === FALSE )
		{
			//Tiene que es registro? 
			if($this->checkFacebookRegistry()){
				return $listener->registry( (array)$fbUser->user );
			}
			
		}else{
			return view('codes.facebook_exists')->with('background','codigo-background.jpg');
		}
	}
	
	private function checkFacebookRegistry(){
		if(Session::get('creation-ref')){
			Session::forget('creation-ref');
			return TRUE;			
		}
		return FALSE;
	}

	private function getAuthorizationFirst()
	{
		return $this->socialite->with('facebook')->redirect();
	}

	public function getFacebookUser()
	{
		return $this->socialite->with('facebook')->user();
	}

}