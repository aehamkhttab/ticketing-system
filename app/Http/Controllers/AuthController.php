<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class  AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }
    public function login(request $request)
    {
        $data = $request->all();
        $creds = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
        $res =Auth::attempt($creds);
       // dd($res);
        if ($res)
        {
            //redirect()->intended('/tickets');
           return redirect()->intended('/tickets');
        }
        else
        {
            return redirect('/auth/login')->with('error','Login Failed');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/login')->with('success', 'You have been logged out.');
    }
    public function signupView()
    {
        return view('auth.signup');
    }
    public function signup(request $request)
    {
        try {
            $data = $request->all();
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);

            $user->save();

            return redirect('/auth/login');
        }catch (Exception $e){
            return redirect('/auth/signup')->with('error',$e->getMessage());
        }

    }
    public function forgetPasswordView()
    {
        return view('auth.forget_password');
    }
    public function forgetPassword(request $request)
    {
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
    public function resetPasswordView($token)
    {
        return view('auth.reset_password', ['token' => $token]);
    }
    public function resetPassword(Request $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
