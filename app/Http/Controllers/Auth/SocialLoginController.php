<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Socialize;
use Auth;
use App\Models\Persona;

class SocialLoginController extends Controller
{
    public function redirectToMicrosoft() {
        return Socialize::with('graph')->redirect();
    }

    public function handleMicrosoftCallback() {
        if ( !request('code') ) {
            return redirect()->route('login')->with('warning', trans('messages.login_error'));
        }
        
        $microsoftUser = Socialize::driver('graph')->user();
        // dd(config('auth.providers.users.model'));
        $user = config('auth.providers.users.model');
        $user = $user::where(['email' => $microsoftUser->getEmail()])->first();

        if ( !$user ){
            return redirect()->route('login')->with('warning', trans('messages.user_not_found'));
        }

        $user->UltimoInicioSesion = Carbon::now();
        $user->SocialLogin = 'microsoft';
        $user->SocialLoginId = $microsoftUser->getId();
        $user->Avatar = $microsoftUser->getAvatar();     
        $user->timestamps = false;
        $user->save();

        Auth::login($user);
        return redirect()->route('home');
    }
}
