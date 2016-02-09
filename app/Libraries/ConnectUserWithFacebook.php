<?php
namespace App\Libraries;


use Illuminate\Contracts\Auth\Guard as Auth;
use Laravel\Socialite\Contracts\Factory as Socialite; 
use App\Model\Dao\UserDao;
// use Socialize;
use App\Libraries\Interfaces\AuthenticateUserListener;
use Session;
use Request; 

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

	public function execute($hasCode, AuthenticateUserListener $listener)
	{
		if ( ! $hasCode )
		{
			return $this->getAuthorizationFirst();
		}

		$fbUser = $this->getFacebookUser();
		$user = $this->users->getByFacebookId( $fbUser );
		
		Session::set('facebook_user', $fbUser->user);

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
				//Tiene que es registro? 
				if($this->checkFacebookRegistry()){
					return $listener->registry( (array)$fbUser->user );
				}
				return redirect('/auth/login')
                        ->withInput(Request::only('email'))
                        ->withErrors([
                            'email' => 'Estas credenciales no coinciden con nuestros registros.']);
			}
		}
		$this->auth->login($user,true);
		return $listener->userHasLoggedIn( $user );


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