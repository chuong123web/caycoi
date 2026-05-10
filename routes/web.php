<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/category', function () {
    return view('category');
})->name('category');

Route::get('/search', function (Request $request) {
    $query = $request->input('q', '');
    return view('search', compact('query'));
})->name('search');

Route::get('/product', function () {
    return view('product');
})->name('product');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function (Request $request) {
    $request->validate([
        'fullName' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'required|string|min:6',
    ]);
    // For demo: just redirect with success message
    return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
})->name('register.post');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|string',
        'password' => 'required|string',
    ]);
    // For demo: just redirect with success message
    return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
})->name('login.post');

Route::post('/logout', function () {
    return redirect()->route('home')->with('success', 'Đã đăng xuất.');
})->name('logout');

Route::post('/api/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('api.orders.store');
