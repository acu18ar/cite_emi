<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use App\Models\Persona;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
       /* $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => config('parameters.auth_google_recaptcha') ? 'required|recaptcha' : ''
        ]);*/
    }


    public function login(Request $request) {
        //dd($request);
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))){
            $user = $this->guard()->getLastAttempted();
            // Make sure the user is active
            if ($user->Activo && $this->attemptLogin($request)){
            // if ($user->Activo) {
                //verifica si hay autenticacion en dos pasos
                if(config('parameters.auth_2step')) {
                    if($this->setTokenLogin($request))
                        return view('auth.tokenLoginVerify', compact('user'));
                    else
                        return redirect(url('/login'));
                }
                //continue normal process to login
                $this->attemptLogin($request);
                $user->UltimoInicioSesion = Carbon::now();
                return $this->sendLoginResponse($request);

            } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['email' => trans('auth.active')]);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function tokenLoginVerify(Request $request) {
        $this->validate($request, [
            'tokenLogin' => 'required'
        ]);

        $user = Persona::where('email', $request->email)->where('Verificado', true)->first();

        if($user && \Hash::check($request->tokenLogin, $user->TokenLogin)) {
            \Auth::login($user);
            return redirect()->route('home');
        } else {
            return view('auth.tokenLoginVerify', compact('user'))->withErrors(['tokenLogin' => 'El código no es válido.']);
        }
    }

    /**
     * Set Token Login for 2step auth
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    protected function setTokenLogin(Request $request)
    {
        $user = Persona::where('email', $request->email)->where('Verificado', 1)->first();
        if($user) {
            // $tokenLogin = strtoupper(str_random(15));
            $tokenLogin = rand(100000,999999);
            $user->TokenLogin = bcrypt($tokenLogin);
            $user->timestamps = false;
            $user->save();

            \Mail::send('emails.tokenLoginVerificacion', ['user' => $user, 'tokenLogin' => $tokenLogin], function ($message) use ($user) {
                $message->from(config('mail.from.address'), config('app.name'));
                $message->to($user->email)->subject('Clave para Inicio Sesión');
            });
            return true;
        } else {
            return false;
            //return view('auth.login')->withErrors(['email' => 'Ocurrio un error iniciando tu sesión, intenta más tarde por favor']);
        }
    }
}
