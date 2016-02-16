<?php
namespace App\Http\Controllers\Auth;
use Redirect;
use Session as UserSession;
use Crypt; 
use Socialize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Session\Store as Session;
use App\Model\UserRepository; use UserRequest; 
use App\Libraries\AuthUserWithFacebook;
use App\Libraries\Interfaces\AuthenticateUserListener;
use App\Libraries\AccountValidation\CompleteAccountSetup;
use App\Model\Dao\UserDao;
use Input;

use Response;
use Config;

class AuthController extends Controller implements AuthenticateUserListener {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    private $session;
    private $checkAccountSetup;
    private $userDao;
    /**
     * Create a new authentication controller instance.
     *
     * @param  Guard  $auth
     * @param  Registrar  $registrar
     * @return void
     */
    public function __construct( Guard $auth, 
                                 Session $session,
                                 CompleteAccountSetup $checkUser,
                                 UserDao $userdao ) {
        $this->auth = $auth;
        $this->session = $session;
        $this->middleware('both', ['only' => 'getLogin']);
        $this->checkAccountSetup = $checkUser;
        $this->userDao = $userdao;
        $this->setLanguage();
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin() 
    {
	    if($this->auth->check()){
		   $this->auth->logout();
	    }
        return view('auth.login')->with('title', 'Login' )->with('background','3.jpg');
    }

    public function getLoginfb(AuthUserWithFacebook $authfb, Request $request)
    {
		return $authfb->execute($request->has('code'), $this);

    }

    public function userHasLoggedIn($user)
    {
        $this->session->flash('message', "Ha iniciado sesión con éxito");
        $this->session->flash('alert-class', 'alert-success');

        return redirect()->intended($this->redirectPath());
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request) {
	    if($this->auth->check()){
		   $this->auth->logout();
	    }
	    
        $this->validate($request, [
            'email' => 'required', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials2['email'] =  trim($credentials['email']);
        $credentials2['password'] =  trim($credentials['password']);

        if ($this->auth->attempt($credentials2, $request->has('remember'))) {
            $this->session->flash('message', "Ha iniciado sesión con éxito");
            $this->session->flash('alert-class', 'alert-success');

          // $this->checkAccountSetup->setUsersID
            //$data = $this->session->all();
            $user = $this->userDao->getUserByEmail( $credentials['email'] );
            $this->checkAccountSetup->setUsersID( $user->id );
            $userpayment = $this->checkAccountSetup->checkCreditCard();
			$affiliation = $this->checkAccountSetup->checkAffiliation();
		           
            return redirect()->intended($this->redirectUserAccountPath());

        }

        return redirect('/auth/login')
                        ->withInput($request->only('email'))
                        ->withErrors([
                            'email' => 'Estas credenciales no coinciden con nuestros registros.',
        ]);
    }
    
    public function getWplogin(Request $request) {
	    if($this->auth->check()){
		   $this->auth->logout();
	    }
	    
        $this->validate($request, [
            'email' => 'required', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials2['email'] =  trim($credentials['email']);
        $credentials2['password'] =  trim($credentials['password']);

        if ($this->auth->attempt($credentials2, $request->has('remember'))) {
            $this->session->flash('message', "Ha iniciado sesión con éxito");
            $this->session->flash('alert-class', 'alert-success');

          // $this->checkAccountSetup->setUsersID
            //$data = $this->session->all();
            $user = $this->userDao->getUserByEmail( $credentials['email'] );
            $this->checkAccountSetup->setUsersID( $user->id );
                       
            return redirect()->intended($this->redirectUserAccountPath());

        }

        return redirect('/auth/login')
                        ->withInput($request->only('email'))
                        ->withErrors([
                            'email' => 'Estas credenciales no coinciden con nuestros registros.',
        ]);
    }
    
    

    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    public function getLogout() {
        $this->auth->logout();
        $this->session->flash('message', "Ha cerrado sesión con éxito");
        $this->session->flash('alert-class', 'alert-danger');
        return redirect('http://'.Config::get('domain.front'));
    }
    
     public function tryAgain() {
        $this->session->flash('message', "No se encuentra conectado");
        $this->session->flash('alert-class', 'alert-danger');
        return redirect('http://'.Config::get('domain.front'));
    }
    
    

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectUserAccountPath() {
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/useraccount';
    }
    
    public function redirectPath() {
        return'/useraccount';
    }

   /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPaymentInfoPath() {
        $this->redirectTo = '/payment';
        return  $this->redirectTo;
    }
   	
	public function getAutologin(Request $request,  $email , $encryptedPassword) {
		$password = Crypt::decrypt($encryptedPassword);
		$credentials = ['email' => $email, 'password' => $password];
		
		UserSession::put(array('email' => $email , 'password' => $encryptedPassword));
		
        if ($this->auth->attempt( $credentials )) {  
			$this->setLanguage();
			return redirect('useraccount');

		}
		return redirect('auth/login')
                ->withInput( [ 'email' => $email ])
                ->withErrors([ 'message' => 'Estas credenciales no coinciden con nuestros registros.' ]);
       	
	}

}