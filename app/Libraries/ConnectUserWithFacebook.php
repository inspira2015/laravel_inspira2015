<?php
namespace App\Libraries;


use Illuminate\Contracts\Auth\Guard as Auth;
use Laravel\Socialite\Contracts\Factory as Socialite; 
use App\Model\Dao\UserDao;
// use Socialize;
// use App\Libraries\Interfaces\AuthenticateUserListener;

class ConnectUserWithFacebook
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

	public function execute($hasCode)
	{
		if ( ! $hasCode )
		{
			return $this->getAuthorizationFirst();
		}

		try{
			$fbUser = $this->getFacebookUser();
		}catch (Exception $e) {
           echo $e;
           exit;
        }


		$user = $this->users->getByFacebookId( $fbUser );
		if ( $user === FALSE )
		{
			$user = $this->users->getByEmail($fbUser->email);

			if($user !== FALSE) {
				$this->users->load($user->id);
				$this->users->facebook_id = $fbUser->id;
				$this->users->facebook_avatar = $fbUser->avatar;
				$this->users->save();
				
				$user = $this->users->getByFacebookId( $fbUser );
			}else{
				return $listener->tryAgain();
			}
		}
	//	$this->auth->login($user,true);
		return $listener->userHasLoggedIn( $user );


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