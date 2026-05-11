<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

Route::get('/debug-error', function () {
    $results = [];

    // Step 1: Basic PHP
    $results['php_version'] = phpversion();

    // Step 2: Database connection
    try {
        \Illuminate\Support\Facades\DB::select('SELECT 1');
        $results['db'] = 'OK';
    } catch (\Throwable $e) {
        $results['db'] = 'FAIL: ' . $e->getMessage();
    }

    // Step 3: Plants model
    try {
        $count = \App\Models\Plant::count();
        $results['plants_count'] = $count;
    } catch (\Throwable $e) {
        $results['plants_model'] = 'FAIL: ' . $e->getMessage();
    }

    // Step 4: Plants active scope
    try {
        $active = \App\Models\Plant::active()->count();
        $results['plants_active'] = $active;
    } catch (\Throwable $e) {
        $results['plants_active'] = 'FAIL: ' . $e->getMessage();
    }

    // Step 5: Spatie Media
    try {
        $plant = \App\Models\Plant::active()->first();
        if ($plant) {
            $url = $plant->getFirstMediaUrl('thumbnail');
            $results['media_url'] = $url ?: '(empty)';
            $results['image_url_attr'] = $plant->image_url;
        } else {
            $results['plant'] = 'no active plant found';
        }
    } catch (\Throwable $e) {
        $results['media'] = 'FAIL: ' . $e->getMessage();
    }

    // Step 6: View composer (globalPlants)
    try {
        $globalPlants = \Illuminate\Support\Facades\Cache::remember('debug_global_plants', 10, function () {
            return \App\Models\Plant::active()->get()->map(function($plant) {
                return [
                    'id' => $plant->slug,
                    'name' => $plant->name,
                    'img' => $plant->image_url,
                ];
            });
        });
        $results['global_plants'] = $globalPlants->count() . ' plants loaded';
    } catch (\Throwable $e) {
        $results['global_plants'] = 'FAIL: ' . $e->getMessage();
    }

    // Step 7: Vite manifest
    try {
        $manifestPath = public_path('build/manifest.json');
        $results['vite_manifest_exists'] = file_exists($manifestPath);
        if (file_exists($manifestPath)) {
            $results['vite_manifest'] = json_decode(file_get_contents($manifestPath), true);
        }
    } catch (\Throwable $e) {
        $results['vite'] = 'FAIL: ' . $e->getMessage();
    }

    // Step 8: Try render view
    try {
        $html = view('home')->render();
        $results['view_render'] = 'OK - ' . strlen($html) . ' bytes';
    } catch (\Throwable $e) {
        $results['view_render'] = 'FAIL: ' . $e->getMessage();
        $results['view_file'] = $e->getFile() . ':' . $e->getLine();
        $results['view_trace'] = collect($e->getTrace())->take(5)->map(fn($t) => ($t['file'] ?? '?') . ':' . ($t['line'] ?? '?'))->toArray();
    }

    return response()->json($results, 200);
});

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
