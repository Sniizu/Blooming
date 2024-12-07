<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function viewHome()
    {
        $categories = Category::where('name', '!=', 'Custom')->orderBy('id', 'asc')->get();
        $categories_count = $categories->count();

        if ($categories_count > 1) {
            $first_category = $categories[0];
            $second_category = $categories[1];

            $category_1 = Item::where("category_id", $first_category->id)->orderBy('created_at', 'desc')->take(4)->get();
            $category_2 = Item::where("category_id", $second_category->id)->orderBy('created_at', 'desc')->take(4)->get();

            $data = compact('category_1', 'category_2');
        } elseif ($categories_count == 1) {
            $first_category = $categories[0];

            $category_1 = Item::where("category_id", $first_category->id)->orderBy('created_at', 'desc')->take(4)->get();

            $data = compact('category_1');
        } else {
            $data = [];
        }

        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                ->where('carts.user_id', $id)
                ->sum('cart_details.qty');

            $data['cart_count'] = $cart_count;
        }

        return view('home', $data);

    }

    public function viewAboutUs()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                ->where('carts.user_id', $id)
                ->sum('cart_details.qty');
            return view('aboutUs', compact('cart_count'));
        }
        return view('aboutUs');
    }

}
