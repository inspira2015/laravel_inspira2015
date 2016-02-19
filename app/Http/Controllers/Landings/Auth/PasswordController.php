<?php namespace App\Http\Controllers\Landings\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

use Illuminate\Mail\Message;

class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;
	protected $redirectTo = '/';
	/**
	 * Create a new password controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
	 * @return void
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords, Request $request)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;

		$this->middleware('guest');
		$this->setLanguage($request->get('lang'));

	}

 	public function postEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject('Recuperación de contraseña');
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
             return view('landings.__common.auth.forgot_password')->withErrors([ Lang::get('auth.reset-link-sent') ]);
            case Password::INVALID_USER:
               return view('landings.__common.auth.forgot_password')->withErrors(['message' => Lang::get('auth.invalid-user')]);
        }
    }
}
