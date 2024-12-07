<?php

namespace App\Http\Controllers;

use App\Models\CartDetail;
use App\Models\Category;
use App\Models\Item;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function viewManageItem()
    {
        $products = Item::whereNotIn('category_id', function ($query) {
            $query->select('id')->from('categories')->where('name', 'Custom');
        })->latest()->filter()->paginate(10);
        return view('admin.manageItem', compact('products'));
    }
    public function viewOrder()
    {
        $orders = TransactionHeader::latest()->get();
        return view('admin.viewOrder', compact('orders'));
    }
    public function viewOrderDetail($id)
    {
        $orderDetail = TransactionHeader::latest('transaction_headers.created_at')->where('transaction_headers.id', '=', $id)
            ->join('transaction_details', 'transaction_headers.id', '=', 'transaction_details.transaction_id')
            ->join('items', 'items.id', '=', 'transaction_details.item_id')
            ->selectRaw('transaction_headers.*')->first();

        // dd($orderDetail);
        return view('admin.viewOrderDetail', compact('orderDetail'));
    }

    public function runUpdateDeliver($id)
    {
        $orders = TransactionHeader::latest()->get();

        $order = TransactionHeader::find($id);

        if ($order) {
            if ($order->delivery_status == 'Delivered') {
                return redirect()->back()->with('success', 'Order Already Delivered');
            }
            $order->delivery_status = 'Delivered';
            $order->save();

            return redirect()->back()->with('success', 'Order delivered successfully');
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }

        return view('admin.viewOrder', compact('orders'));
    }

    public function viewDashboard()
    {
        $product_count = Item::all()->count();
        $sales_count = TransactionHeader::all()->count();
        $delivery_count = TransactionHeader::where('delivery_status', 'Delivered')->count();
        $order = TransactionHeader::all();
        return view('admin.dashboard', compact('product_count', 'sales_count', 'delivery_count', 'order'));
    }

    public function viewAddItem()
    {
        $category = Category::where('name', '!=', 'Custom')->get();

        return view('admin.addItem', compact('category'));
    }

    public function runAddItem(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required|unique:items|string|min:3|max:3',
            'name' => 'required|unique:items|string|max:20',
            'price' => 'required|numeric|gte:500',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image',
            'description' => 'required|string|max:500',
        ], [
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Please select a category.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image = $req->file('image');
        $imageName = date('YmdHi') . $image->getClientOriginalName();
        $imageURL = 'images/' . $imageName;

        // $destinationPath = public_path('images');
        // Hosting Path
        $destinationPath = base_path('../public_html/images');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }
        $image->move($destinationPath, $imageName);

        $item = new Item([
            'id' => $req->id,
            'name' => $req->name,
            'price' => $req->price,
            'description' => $req->description,
            'image' => $imageURL,
            'category_id' => $req->category_id,
        ]);
        $item->save();
        return redirect('/viewItem')->with('success', 'Item Successfully Added!');
    }

    public function viewUpdateItem(Item $product)
    {

        $category = Category::where('name', '!=', 'Custom')->get();

        return view('admin.updateItem', [
            'title' => "updateItem",
            "product" => $product,
            "category" => $category,
        ]);
    }

    public function runUpdateItem(Request $req, Item $product)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|unique:items,name,' . $product->id . '|string|max:20',
            'price' => 'required|numeric|gte:500',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image',
            'description' => 'required|string|max:500',
        ], [
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Please select a valid category.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If image is uploaded, handle image processing
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = date('YmdHi') . $image->getClientOriginalName();
            Storage::putFileAs('public/images', $image, $imageName);
            $imageURL = 'images/' . $imageName;
        } else {
            // If no new image is uploaded, retain the existing image URL
            $imageURL = $product->image;
        }

        // Update item data
        $product->name = $req->input('name');
        $product->price = $req->input('price');
        $product->category_id = $req->input('category_id');
        $product->description = $req->input('description');
        $product->image = $imageURL;
        $product->save();
        return redirect('/viewItem')->with('success', 'Item Successfully Updated!');
    }

    public function deleteItem(item $product)
    {
        Item::destroy($product->id);
        return redirect('/viewItem')->with('success', 'Item Successfully Deleted!');
    }

    public function viewManageCategory()
    {

        $category = Category::where('name', '!=', 'Custom')->latest()->filter()->paginate(10);
        return view('admin.manageCategory', compact('category'));
    }

    public function deleteCategory(Category $product)
    {

        Category::destroy($product->id);

        //Cart Detail
        CartDetail::whereIn('item_id', function ($query) use ($product) {
            $query->select('id')
                ->from('items')
                ->where('category_id', $product->id);
        })->delete();

        //Transaction History
        $headerIdsToDelete = TransactionDetail::whereHas('item', function ($query) use ($product) {
            $query->select('id')
                ->from('items')
                ->where('category_id', $product->id);
        })->pluck('transaction_id')->unique()->toArray();

        if (!empty($headerIdsToDelete)) {
            TransactionHeader::whereIn('id', $headerIdsToDelete)->delete();
            TransactionDetail::whereIn('transaction_id', $headerIdsToDelete)->delete();
        }

        //Item
        Item::where('category_id', $product->id)->delete();
        return redirect('/viewCategory')->with('success', 'Item Successfully Deleted!');
    }

    public function viewAddCategory()
    {
        $category = Category::where('name', '!=', 'Custom')->get();

        return view('admin.addCategory', compact('category'));
    }

    public function runAddCategory(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|unique:items|string|max:20',
            'description' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = new Category([
            'name' => $req->name,
            'description' => $req->description,
        ]);
        $category->save();
        return redirect('/viewCategory')->with('success', 'Category Successfully Added!');
    }

    public function viewUpdateCategory(Category $product)
    {

        return view('admin.updateCategory', [
            'title' => "updateItem",
            "product" => $product,
        ]);
    }

    public function runUpdateCategory(Request $req, Category $product)
    {

        $rules = [
            'description' => 'required|string|max:500',
        ];

        if ($req->name != $product->name) {
            $rules['name'] = 'required|unique:items|string|max:20';
        }

        $validator = $req->validate($rules);
        Category::where('id', $product->id)->update($validator);

        return redirect('/viewCategory')->with('success', 'Category Successfully Updated!');
    }
}
