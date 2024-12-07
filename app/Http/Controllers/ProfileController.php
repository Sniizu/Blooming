<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function runLogout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }

    public function viewEdit()
    {

        $user = auth()->user();
        $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $user->id)
            ->sum('cart_details.qty');
        return view('editProfile', compact('user', 'cart_count'));
    }

    public function runEditProfile(Request $request)
    {
        $rules = [
            'username' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
        ];
        $request->validate($rules);

        $user = User::find(auth()->user()->id);
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->save();

        $userSessionData = Session::get('user');
        $userSessionData['username'] = $request->input('username');
        $userSessionData['email'] = $request->input('email');
        Session::put('user', $userSessionData);

        Session::regenerate();

        return redirect('/editProfile')->with('success', 'Profile Successfully Updated!');
    }

    public function viewChange()
    {
        $user = auth()->user();
        $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $user->id)
            ->sum('cart_details.qty');
        return view('changePassword', compact('user', 'cart_count'));
    }

    public function runChangePassword(Request $request)
    {

        $rules = [
            'password' => 'required',
            'newpassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newpassword',
        ];
        $request->validate($rules);

        $user = User::find(auth()->user()->id);
        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()->back()->with('fail', 'Incorrect old password');
        }
        $user->password = Hash::make($request->input('newpassword'));
        $user->save();

        return redirect()->back()->with('success', 'Password Successfully Changed!');
    }
}
