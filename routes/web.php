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
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:6',
        'gender' => 'required|in:male,female,other',
        'birthdate' => 'required|date|before:today',
    ]);

    $user = \App\Models\User::create([
        'name' => $request->fullName,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'gender' => $request->gender,
        'birthdate' => $request->birthdate,
    ]);

    \Illuminate\Support\Facades\Auth::login($user);

    return redirect()->route('home')->with('success', 'Đăng ký thành công! Chào mừng bạn đến Verdant! 🌿');
})->name('register.post');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|string',
        'password' => 'required|string',
    ]);

    if (\Illuminate\Support\Facades\Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended(route('home'))->with('success', 'Đăng nhập thành công!');
    }

    return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.']);
})->name('login.post');

Route::post('/logout', function (Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home')->with('success', 'Đã đăng xuất.');
})->name('logout');

Route::post('/api/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('api.orders.store');

// Analytics API for Admin
Route::get('/api/analytics', [\App\Http\Controllers\AnalyticsController::class, 'index'])->name('api.analytics');
Route::get('/api/analytics/run-python', [\App\Http\Controllers\AnalyticsController::class, 'runPythonAnalysis'])->name('api.analytics.python');
