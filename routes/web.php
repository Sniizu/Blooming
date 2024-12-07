<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// All
Route::get('/', [Controller::class, 'viewHome'])->name('home');
Route::get('/home', [Controller::class, 'viewHome']);
Route::get('/aboutUs', [Controller::class, 'viewAboutUs']);

//CONTACT
Route::get('/contact', [ContactController::class, 'viewContact']);
Route::post('/post_message', [ContactController::class, 'post_message']);

//REGISTER
Route::get('/register', [RegisterController::class, 'viewRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'runRegister']);
Route::get('/verify-email/{token}', [RegisterController::class, 'verifyEmail'])->name('verify.email');

// LOGIN
Route::get('/login', [LoginController::class, 'viewLogin'])->name('login');
Route::post('/login', [LoginController::class, 'runLogin']);
Route::get('/forgetPassword', [LoginController::class, 'forgetPassword'])->name('forgetPassword');
Route::post('/forgetPassword', [LoginController::class, 'runForgetPassword']);
Route::get('/resetPassword/{token}', [LoginController::class, 'resetPassword'])->name('resetPassword');
Route::post('/resetPassword', [LoginController::class, 'runResetPassword']);

// PROFILE
Route::get('/editProfile', [ProfileController::class, 'viewEdit'])->name('viewEdit');
Route::put('/editProfile', [ProfileController::class, 'runEditProfile'])->name('runEditProfile');
Route::get('/changePassword', [ProfileController::class, 'viewChange'])->name('viewChange');
Route::post('/changePassword', [ProfileController::class, 'runChangePassword'])->name('runChangePassword');
Route::get('/logout', [ProfileController::class, 'runLogout'])->name('logout');

// Product
Route::get('/showProduct', [ProductController::class, 'viewProducts'])->name('viewProducts');
Route::get('/products/{product:id}', [ProductController::class, 'viewProductDetail'])->name('productDetail');
Route::get('/showProduct/{category}', [ProductController::class, 'filterProduct'])->name('filterProduct');
Route::get('/showProduct/{category}/{order}', [ProductController::class, 'orderProducts'])->name('orderProducts');

// Admin
Route::get('/viewItem', [AdminController::class, 'viewManageItem'])->middleware('authenticaterole:admin')->name('viewItem');
Route::get('/addItem', [AdminController::class, 'viewAddItem'])->name('addItem')->middleware('authenticaterole:admin');
Route::post('/addItem', [AdminController::class, 'runAddItem'])->middleware('authenticaterole:admin');
Route::get('/updateItem/{product:id}', [AdminController::class, 'viewUpdateItem'])->name('updateItem')->middleware('authenticaterole:admin');
Route::put('/updateItem/{product:id}', [AdminController::class, 'runUpdateItem'])->middleware('authenticaterole:admin');
Route::delete('/deleteItem/{product:id}', [AdminController::class, 'deleteItem'])->middleware('authenticaterole:admin');

Route::get('/viewCategory', [AdminController::class, 'viewManageCategory'])->middleware('authenticaterole:admin')->name('viewManageCategory');
Route::get('/addCategory', [AdminController::class, 'viewAddCategory'])->name('viewAddCategory')->middleware('authenticaterole:admin');
Route::post('/addCategory', [AdminController::class, 'runAddCategory'])->middleware('authenticaterole:admin');
Route::get('/updateCategory/{product:id}', [AdminController::class, 'viewUpdateCategory'])->name('updateCategory')->middleware('authenticaterole:admin');
Route::put('/updateCategory/{product:id}', [AdminController::class, 'runUpdateCategory'])->middleware('authenticaterole:admin');
Route::delete('/deleteCategory/{product:id}', [AdminController::class, 'deleteCategory'])->middleware('authenticaterole:admin');

Route::get('/dashboard', [AdminController::class, 'viewDashboard'])->name('viewDashboard')->middleware('authenticaterole:admin');
Route::get('/viewOrder', [AdminController::class, 'viewOrder'])->name('viewOrder')->middleware('authenticaterole:admin');
Route::get('/viewOrderDetail/{id}', [AdminController::class, 'viewOrderDetail'])->name('viewOrderDetail')->middleware('authenticaterole:admin');
Route::get('/runUpdateDeliver/{id}', [AdminController::class, 'runUpdateDeliver'])->middleware('authenticaterole:admin');

// User
Route::get('/cartList', [UserController::class, 'viewCart'])->middleware('authenticaterole:customer')->name('cartList');
Route::post('/addcart', [UserController::class, 'runAddCart'])->middleware('authenticaterole:customer');
Route::get('/updateCartqty/{product:id}', [UserController::class, 'viewUpdateCart'])->middleware('authenticaterole:customer');
Route::put('/updateCartItem', [UserController::class, 'runUpdateCartqty'])->middleware('authenticaterole:customer');
Route::post('/deleteCartItem', [UserController::class, 'runDeleteCartItem'])->middleware('authenticaterole:customer');

Route::get('/transactionHistory', [UserController::class, 'viewTransaction'])->middleware('authenticaterole:customer')->name('transactionHistory');
Route::get('/checkOutForm', [UserController::class, 'checkOutForm'])->middleware('authenticaterole:customer')->name('checkOutForm');
Route::post('/checkout', [UserController::class, 'runCheckout'])->middleware('authenticaterole:customer');

Route::get('/customOrder', [UserController::class, 'customOrder'])->middleware('authenticaterole:customer')->name('customOrder');
Route::post('/addCartCustom', [UserController::class, 'runAddCartCustom'])->middleware('authenticaterole:customer');
