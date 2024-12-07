<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function viewRegister()
    {
        if (Session::get('user')) {
            return redirect()->route('home');
        }

        return view('register');
    }

    public function runRegister(Request $req)
    {
        $rules = [
            'fullname' => 'required|string|min:3',
            'email' => 'unique:users,email|email',
            'password' => 'required|string|min:6',
            'confirmPassword' => 'required|same:password',
        ];

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user = new User();
        $user->username = $req->fullname;
        $user->email = $req->email;
        $user->role = 'customer';
        $user->password = Hash::make($req->password, [
            'rounds' => 12,
        ]);
        $user->email_verification_token = Str::random(32);
        $user->save();

        $verificationLink = route('verify.email', ['token' => $user->email_verification_token]);
        Mail::to($user->email)->send(new VerifyEmail($user, $verificationLink));

        return redirect()->route('login')->with('register_success', 'Account Successfully Registered! Please check your email to verify your account.');
    }

    public function verifyEmail($token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid verification token.');
        }

        $user->verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        return redirect()->route('login')->with('register_success', 'Email verified. You can now login.');
    }

}
