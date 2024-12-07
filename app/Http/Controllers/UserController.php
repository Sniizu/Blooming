<?php

namespace App\Http\Controllers;

use App\Models\CartDetail;
use App\Models\Carts;
use App\Models\Category;
use App\Models\Item;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //CART
    public function viewCart()
    {

        $id = Auth::user()->id;
        $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $id)
            ->sum('cart_details.qty');

        $cartitems = Carts::latest('carts.created_at')->where('carts.user_id', '=', strval(Session::get('user')['id']))
            ->join('cart_details', 'carts.id', '=', 'cart_details.cart_id')->join('items', 'items.id', '=', 'cart_details.item_id')
            ->groupBy('carts.id')->selectRaw('sum(qty*price) as sum,sum(qty) as ctr, carts.id')->first();

        if ($cartitems) {
            foreach ($cartitems->cartDetail as $cartDetail) {
                $cartDetail->detail_item = json_decode($cartDetail->detail_item);
            }
        }

        return view('user.cartList', [
            'title' => 'Cart Page',
            'cartitems' => $cartitems,
            'cart_count' => $cart_count,
        ]);
    }

    public function runAddCart(Request $req)
    {
        $validator = $req->validate([
            'qty' => 'required|integer|gte:1',
            "id" => 'exists:items',
        ]);
        if (!Session::get('user')) {
            return redirect()->route('login');
        }
        if (Carts::where('user_id', '=', strval(Session::get('user')['id']))->get()->count() == 0) {
            $cart = new Carts();
            $cart->user_id = Session::get('user')['id'];
            $cart->save();
        }
        $cartId = Carts::where('user_id', '=', strval(Session::get('user')['id']))->select('id')->first()['id'];
        if (CartDetail::where([['cart_id', '=', $cartId], ['item_id', '=', $validator['id']]])->get()->count() != 0) {
            CartDetail::where([['cart_id', '=', $cartId], ['item_id', '=', $validator['id']]])->increment('qty', $validator['qty']);
        } else {
            $cartDetail = new CartDetail();
            $cartDetail->cart_id = $cartId;
            $cartDetail->item_id = $validator['id'];
            $cartDetail->qty = $validator['qty'];
            $cartDetail->detail_item = null;
            $cartDetail->save();
        }
        return back()->with('success', 'Added to Cart!');
    }

    public function viewUpdateCart(Item $product)
    {
        $id = Auth::user()->id;
        $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $id)
            ->sum('cart_details.qty');

        return view('user.updateCart', [
            'title' => "Update Cart Item",
            "product" => $product,
            "qty" => Carts::where('user_id', '=', strval(Session::get('user')['id']))->first()->cartDetail()->where('cart_details.item_id', '=', $product->id)->first()['qty'],
            "cart_count" => $cart_count,
        ]);
    }
    public function runUpdateCartqty(Request $req)
    {
        $rules = [
            'qty' => 'required|gte:1',
            "id" => 'exists:items',
        ];

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if (!Session::get('user') || Carts::where('user_id', '=', strval(Session::get('user')['id']))->get()->count() == 0) {
            return redirect()->route('login');
        }
        $header = Carts::where('user_id', '=', strval(Session::get('user')['id']))->first('id');
        CartDetail::where([['cart_id', '=', $header['id']], ['item_id', '=', $req->id]])->update(['qty' => $req->qty]);
        return back()->with('success', 'Updated!');
    }

    public function runDeleteCartItem(Request $req)
    {

        if (!Session::get('user') || Carts::where('user_id', '=', strval(Session::get('user')['id']))->get()->count() == 0) {
            return redirect()->route('login');
        }
        CartDetail::where([['cart_id', '=', $req->cart_id], ['item_id', '=', $req->item_id]])->delete();
        return back()->with('success', 'Cart Deleted');
    }

    public function viewTransaction()
    {
        $id = Auth::user()->id;
        $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $id)
            ->sum('cart_details.qty');

        $history = TransactionHeader::latest('transaction_headers.created_at')->where('transaction_headers.user_id', '=', strval(Session::get('user')['id']))
            ->join('transaction_details', 'transaction_headers.id', '=', 'transaction_details.transaction_id')
            ->join('items', 'items.id', '=', 'transaction_details.item_id')
            ->groupBy(['transaction_headers.id', 'transaction_headers.created_at', 'transaction_headers.subtotal', 'transaction_headers.delivery_cost', 'transaction_headers.service_fee', 'transaction_headers.total_price', 'transaction_headers.delivery_option', 'transaction_headers.delivery_status', 'transaction_headers.payment_status'])
            ->selectRaw('sum(qty) as ctr,transaction_headers.subtotal, transaction_headers.delivery_cost, transaction_headers.service_fee, transaction_headers.total_price, transaction_headers.delivery_option, transaction_headers.delivery_status, transaction_headers.payment_status , transaction_headers.id, transaction_headers.created_at as created')->get();

        if ($history) {
            foreach ($history as $transaction) {
                foreach ($transaction->transactionDetail as $detail) {
                    $detail->detail_item = json_decode($detail->detail_item);
                }
            }
        }

        return view('user.transactionHistory', [
            'title' => 'Transaction History',
            'histories' => $history,
            'cart_count' => $cart_count,
        ]);
    }

    public function runCheckout(Request $req)
    {
        $rules = [
            'email' => 'required|email',
            'senderName' => 'required|string',
            'senderPhone' => ['required', 'regex:/^08[0-9]{8,11}$/'],
            'recipientName' => 'required|string',
            'recipientNumber' => ['required', 'regex:/^08[0-9]{8,11}$/'],
            'deliveryOption' => 'required|in:car,motorcycle',
            'datepicker' => 'required|date',
            'deliveryTime' => 'required|string|in:9am - 2pm,3pm - 5pm',
            'province' => 'required|string',
            'city' => 'required|string',
            'postalCode' => 'required|string|max:7',
            'deliveryAddress' => 'required|string',
            'paymentMethod' => 'required|string',
            'subTotal' => 'string',
            'deliveryPrice' => 'string',
            'serviceFee' => 'string',
            'totalPrice' => 'string',
        ];

        $messages = [
            'senderPhone.regex' => 'Sender Phone must start with 08 and be between 10 to 13 digits long.',
            'recipientNumber.regex' => 'Recipient Phone must start with 08 and be between 10 to 13 digits long.',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $transheader = new TransactionHeader();
        $transheader->user_id = Session::get('user')['id'];
        $transheader->sender_email = $req->email;
        $transheader->sender_name = $req->senderName;
        $transheader->sender_phone = $req->senderPhone;
        $transheader->receiver_name = $req->recipientName;
        $transheader->receiver_phone = $req->recipientNumber;
        $transheader->delivery_option = $req->deliveryOption;
        $transheader->delivery_date = date('Y-m-d', strtotime($req->datepicker));
        $transheader->delivery_time = $req->deliveryTime;
        $transheader->province = $req->province;
        $transheader->city = $req->city;
        $transheader->postal_code = $req->postalCode;
        $transheader->delivery_address = $req->deliveryAddress;
        $transheader->payment_method = $req->paymentMethod;
        $transheader->subtotal = $req->subTotal;
        $transheader->delivery_cost = $req->deliveryPrice;
        $transheader->service_fee = $req->serviceCost;
        $transheader->total_price = $req->totalPrice;
        $transheader->delivery_status = "Processing";
        $transheader->payment_status = "Paid";
        $transheader->save();

        $cartdetail = CartDetail::where('cart_id', '=', $req->cart_id)->get();
        foreach ($cartdetail as $detail) {
            $transdetail = new TransactionDetail();
            $transdetail->transaction_id = $transheader->id;
            $transdetail->item_id = $detail->item_id;
            $transdetail->qty = $detail->qty;
            $transdetail->detail_item = $detail->detail_item;
            $transdetail->save();
        }
        CartDetail::where('cart_id', '=', $req->cart_id)->delete();
        return redirect()->route('transactionHistory');
    }

    public function checkOutForm()
    {
        $id = Auth::user()->id;
        $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $id)
            ->sum('cart_details.qty');

        $cart_items = Carts::latest('carts.created_at')->where('carts.user_id', '=', strval(Session::get('user')['id']))
            ->join('cart_details', 'carts.id', '=', 'cart_details.cart_id')->join('items', 'items.id', '=', 'cart_details.item_id')
            ->groupBy('carts.id')->selectRaw('sum(qty*price) as sum,sum(qty) as ctr, carts.id')->first();

        return view('user.checkOutForm', compact('cart_count', 'cart_items'));
    }

    public function customOrder()
    {
        $id = Auth::user()->id;
        $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $id)
            ->sum('cart_details.qty');

        return view('user.customerOrder', compact('cart_count'));
    }

    public function runAddCartCustom(Request $req)
    {

        $req->validate([
            'size' => 'required', // Ensure size radio button is selected
            'flower' => 'required|array|min:1', // Ensure at least one flower checkbox is selected
            'fillers' => 'array', // Optional: define rules for fillers if required
            'leaves' => 'required', // Ensure one leaf radio button is selected
            'color' => 'required', // Ensure one paper color radio button is selected
            'ribbon' => 'required', // Ensure one ribbon radio button is selected
            'total_price' => 'required|numeric', // Ensure total_price is required and numeric
            'image_url' => 'required', // Ensure image_url is required
        ]);

        $detailItem = json_encode($req->except('_token', 'total_price'));

        if (!Session::get('user')) {
            return redirect()->route('login');
        }
        if (Carts::where('user_id', '=', strval(Session::get('user')['id']))->get()->count() == 0) {
            $cart = new Carts();
            $cart->user_id = Session::get('user')['id'];
            $cart->save();
        }

        $cartId = Carts::where('user_id', '=', strval(Session::get('user')['id']))->select('id')->first()['id'];

        $itemCustom = Item::where('category_id', '=', Category::where('name', 'Custom')->value('id'))->first();

        if ($itemCustom) {
            $itemCustom->price = $req->total_price;
            $itemCustom->image = $req->image_url;
            $itemCustom->save();
        }

        $itemId = Item::where('category_id', '=', Category::where('name', 'Custom')->value('id'))->select('id')->first()['id'];

        if (CartDetail::where([['cart_id', '=', $cartId], ['item_id', '=', $itemId]])->get()->count() != 0) {
            return back()->withErrors('You can only add 1 custom order to cart');
        } else {
            $cartDetail = new CartDetail();
            $cartDetail->cart_id = $cartId;
            $cartDetail->item_id = $itemId;
            $cartDetail->qty = 1;
            $cartDetail->detail_item = $detailItem;
            $cartDetail->save();
        }
        return back()->with('message', 'Added to Cart!');
    }
}
