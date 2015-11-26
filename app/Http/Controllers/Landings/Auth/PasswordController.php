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
	public function __construct(Guard $auth, PasswordBroker $passwords)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;

		$this->middleware('guest');
		$this->setLanguage();
	}

 	public function postEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject('Recuperación de contraseña');
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
             return view('uber.auth.forgot_password')->withErrors(["Se ha enviado exitosamente el correo. Por favor revise su bandeja."]);
            case Password::INVALID_USER:
               return view('uber.auth.forgot_password')->withErrors(['message' => 'El correo es incorrecto. Favor de intentar de nuevo o contacte al administrador en customerservice@inspiramexico.mx']);
        }
    }
}
