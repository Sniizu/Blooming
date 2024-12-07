<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Mail\VerifyEmail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function viewLogin()
    {
        if (Session::get('user')) {
            return redirect()->route('home');
        }

        return view('login');
    }

    public function runLogin(Request $req)
    {
        $rules = [
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user = Auth::getProvider()->retrieveByCredentials([
            'email' => $req->email,
        ]);

        $credentials = [
            'email' => $req->email,
            'password' => $req->password,
        ];

        if (!$user || !Auth::attempt($credentials)) {
            return back()->withErrors('invalid credentials');
        }

        if (!$user->verified_at) {

            $user->email_verification_token = Str::random(32);
            $user->save();

            $verificationLink = route('verify.email', ['token' => $user->email_verification_token]);
            Mail::to($user->email)->send(new VerifyEmail($user, $verificationLink));

            Auth::logout();
            return back()->withErrors('Please verify your email before logging in.');
        }

        Session::put('user', Auth::user());

        if ($req->remember === 'on') {

            Cookie::queue('email', $req->email, 20);
            Cookie::queue('password', $req->password, 20);
        } else {
            Cookie::queue(Cookie::forget('email'));
            Cookie::queue(Cookie::forget('password'));
        }

        if (Session::get('user')['role'] === 'admin') {
            return redirect('/dashboard');
        }

        return redirect('/home');
    }

    public function forgetPassword()
    {
        return view('forgetPassword');
    }

    public function runForgetPassword(Request $request)
    {
        $customMessage = [
            'email.exists' => 'The email is not registered',
        ];

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], $customMessage);

        $token = Str::random(60);
        PasswordReset::updateOrCreate(
            [
                'email' => $request->email,
            ],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token));

        return redirect()->back()->with('success', 'We\'ve sent you an email with a link to reset your password');

    }

    public function resetPassword(Request $request, $token)
    {

        $getToken = PasswordReset::where('token', $token)->first();

        if (!$getToken) {
            return redirect()->route('login')->with('failed', 'Token invalid');
        }
        return view('resetPassword', compact('token'));
    }

    public function runResetPassword(Request $request)
    {
        $rules = [
            'password' => 'required',
            'newpassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newpassword',
        ];
        $request->validate($rules);

        $token = PasswordReset::where('token', $request->token)->first();

        if (!$token) {
            return redirect()->route('login')->with('failed', 'Token Invalid');
        }

        $user = User::where('email', $token->email)->first();

        if (!$user) {
            return redirect()->route('login')->with('failed', 'The email is not registered');
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()->back()->with('failed', 'Incorrect old password');
        }

        $user->password = Hash::make($request->input('newpassword'));
        $user->save();

        $token->delete();
        return redirect()->route('login')->with('register_success', 'Password Successfully Reset!');
    }
}
