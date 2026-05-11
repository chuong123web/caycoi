<?php
// Emergency fix: delete corrupted cache files, then diagnose
header('Content-Type: application/json');
$results = [];

// Delete corrupted cache files FIRST
$cacheFiles = [
    __DIR__.'/../bootstrap/cache/config.php',
    __DIR__.'/../bootstrap/cache/routes-v7.php',
    __DIR__.'/../bootstrap/cache/services.php',
    __DIR__.'/../bootstrap/cache/packages.php',
    __DIR__.'/../bootstrap/cache/events.php',
];

foreach ($cacheFiles as $file) {
    if (file_exists($file)) {
        $deleted = @unlink($file);
        $results['cache_deleted'][] = basename($file) . ($deleted ? ' ✅' : ' ❌');
    }
}

// Now try booting the app
try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->boot();
    
    $results['boot'] = 'OK';
    $results['php_version'] = phpversion();
    
    // Test DB
    try {
        $pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();
        $results['db'] = 'OK: ' . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    } catch (\Throwable $e) {
        $results['db'] = 'FAIL: ' . $e->getMessage();
    }

    // Check plants
    try {
        $results['plants_count'] = \App\Models\Plant::count();
        $results['active_plants'] = \App\Models\Plant::where('is_active', true)->count();
    } catch (\Throwable $e) {
        $results['plants'] = 'FAIL: ' . $e->getMessage();
    }

    // Check users/roles
    try {
        $results['users_count'] = \App\Models\User::count();
        $admin = \App\Models\User::where('email', 'admin@verdant.vn')->first();
        $results['admin_exists'] = $admin ? 'YES (roles: ' . $admin->getRoleNames()->implode(',') . ')' : 'NO';
    } catch (\Throwable $e) {
        $results['users'] = 'FAIL: ' . $e->getMessage();
    }

    // Try rendering home view
    try {
        $globalPlants = \App\Models\Plant::where('is_active', true)->get()->map(function($plant) {
            return [
                'id' => $plant->slug, 'name' => $plant->name,
                'vn' => $plant->name_vi ?: $plant->name, 'price' => $plant->price,
                'tag' => $plant->tag, 'cat' => $plant->category,
                'light' => $plant->light, 'img' => $plant->image_url,
                'description' => $plant->description, 'care_instructions' => $plant->care_instructions,
            ];
        });
        $html = view('home', ['globalPlants' => $globalPlants])->render();
        $results['view_render'] = 'OK - ' . strlen($html) . ' bytes';
    } catch (\Throwable $e) {
        $results['view_render'] = 'FAIL: ' . $e->getMessage();
        $results['view_file'] = $e->getFile() . ':' . $e->getLine();
    }

} catch (\Throwable $e) {
    $results['fatal'] = $e->getMessage();
    $results['fatal_file'] = $e->getFile() . ':' . $e->getLine();
}

echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
