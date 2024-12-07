<?php

namespace App\Http\Controllers;

use App\Mail\sendMail;
use App\Models\Carts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function viewContact()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                ->where('carts.user_id', $id)
                ->sum('cart_details.qty');
            return view('contact', compact('cart_count'));
        }
        return view('contact');
    }

    public function post_message(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];

        Mail::to('developerbocil@gmail.com')->send(new sendMail($data));

        return redirect()->back()->with('message', 'Thanks for reaching out. Your message has been sent successfully.');

    }
}
