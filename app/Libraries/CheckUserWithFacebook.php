<?php
namespace App\Libraries;


use Illuminate\Contracts\Auth\Guard as Auth;
use Laravel\Socialite\Contracts\Factory as Socialite; 
use App\Model\Dao\UserDao;
// use Socialize;
use App\Libraries\Interfaces\AuthenticateUserListener;
use Session;
use Config;
use Lang;

class CheckUserWithFacebook
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
		
		
		Session::forget('check-ref');

		if ( $user === FALSE )
		{
			//Tiene que es registro? 
			if(!$this->checkFacebookRegistry()){
			//	$fbUser->user['avatar'] = $fbUser->avatar;
			//	return $listener->registry( (array)$fbUser->user );
				return redirect('codes?ref=fb');
			}
		}

		$view = htmlentities(view('codes.facebook_exists')->with('avatar', $fbUser->avatar));
		$message = urlencode(Lang::get('auth.check-facebook-error'));
	
		$url = '//'.Config::get('domain.front');
        if(Lang::getLocale() == 'en'){
	        $url.= '/en';
        }
        
	    //Change this later - it works in production.
		$link = "<script>this.window.close(); var myWindow = window.open('{$url}?error_message={$message}#openModal', '_self');myWindow.focus();</script>";

		echo $link;
		return '';
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