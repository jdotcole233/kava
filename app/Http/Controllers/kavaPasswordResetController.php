<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class kavaPasswordResetController extends Controller
{

    function resetPassword ($token)
    {
        return view('reset.password', ['token' => $token]);
    }

   function passwordReset (Request $request)
   {
    $request->validate([
        'token' => 'required',
        'password' => 'required|min:8|confirmed',
        'email' => 'required|email'
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'first_time_login' => false
            ])->setRememberToken(Str::random(60));
            $user->save();
        }
    );

    return $status == Password::PASSWORD_RESET 
    ? redirect('https://google.com')->with('status', __($status)) 
    : back()->withErrors([
        'email' => [__($status)]
    ]);
   }
}
