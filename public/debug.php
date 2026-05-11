<?php
// Quick debug script - bypasses all Laravel middleware
// Access via: https://caycoi-production.up.railway.app/debug.php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

header('Content-Type: application/json');

$results = [];

try {
    $results['php_version'] = phpversion();
    $results['app_env'] = env('APP_ENV', '(not set)');
    $results['app_debug'] = env('APP_DEBUG', '(not set)');
    $results['db_connection'] = env('DB_CONNECTION', '(not set)');
    $results['db_host'] = env('DB_HOST', '(not set)');

    // Test DB
    $app->boot();
    
    try {
        $pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();
        $results['db'] = 'Connected OK: ' . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    } catch (\Throwable $e) {
        $results['db'] = 'FAIL: ' . $e->getMessage();
    }

    // Check tables
    try {
        $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
        $results['tables'] = array_map(fn($t) => array_values((array)$t)[0], $tables);
    } catch (\Throwable $e) {
        $results['tables'] = 'FAIL: ' . $e->getMessage();
    }

    // Check Vite manifest
    $manifestPath = __DIR__ . '/build/manifest.json';
    $results['vite_manifest_exists'] = file_exists($manifestPath);
    $results['build_dir_exists'] = is_dir(__DIR__ . '/build');
    if (file_exists($manifestPath)) {
        $results['vite_manifest'] = json_decode(file_get_contents($manifestPath), true);
    }
    
    // Check build assets exist
    if (is_dir(__DIR__ . '/build/assets')) {
        $results['build_assets'] = scandir(__DIR__ . '/build/assets');
    }

    // Check storage link
    $results['storage_link'] = file_exists(__DIR__ . '/storage');
    $results['storage_is_link'] = is_link(__DIR__ . '/storage');
    $results['storage_is_dir'] = is_dir(__DIR__ . '/storage');

    // Check view cache
    $viewCachePath = storage_path('framework/views');
    $results['view_cache_dir'] = is_dir($viewCachePath);
    if (is_dir($viewCachePath)) {
        $cachedViews = glob($viewCachePath . '/*.php');
        $results['cached_views_count'] = count($cachedViews);
    }

    // Check config cache
    $configCachePath = base_path('bootstrap/cache/config.php');
    $results['config_cached'] = file_exists($configCachePath);
    
    // Check route cache
    $routeCachePath = base_path('bootstrap/cache/routes-v7.php');
    $results['route_cached'] = file_exists($routeCachePath);

    // Try loading plants
    try {
        $plantCount = \App\Models\Plant::count();
        $results['plants_total'] = $plantCount;
        $activePlants = \App\Models\Plant::where('is_active', true)->count();
        $results['plants_active'] = $activePlants;
    } catch (\Throwable $e) {
        $results['plants'] = 'FAIL: ' . $e->getMessage();
    }

    // Try rendering view
    try {
        // First set globalPlants for the view composer
        $globalPlants = \App\Models\Plant::where('is_active', true)->get()->map(function($plant) {
            return [
                'id' => $plant->slug,
                'name' => $plant->name,
                'vn' => $plant->name_vi ?: $plant->name,
                'price' => $plant->price,
                'tag' => $plant->tag,
                'cat' => $plant->category,
                'light' => $plant->light,
                'img' => $plant->image_url,
                'description' => $plant->description,
                'care_instructions' => $plant->care_instructions,
            ];
        });
        
        $html = view('home', ['globalPlants' => $globalPlants])->render();
        $results['view_render'] = 'OK - ' . strlen($html) . ' bytes';
    } catch (\Throwable $e) {
        $results['view_render'] = 'FAIL: ' . $e->getMessage();
        $results['view_file'] = $e->getFile() . ':' . $e->getLine();
        $results['view_trace'] = array_slice(array_map(function($t) {
            return ($t['file'] ?? '?') . ':' . ($t['line'] ?? '?');
        }, $e->getTrace()), 0, 10);
    }
} catch (\Throwable $e) {
    $results['fatal'] = $e->getMessage();
    $results['fatal_file'] = $e->getFile() . ':' . $e->getLine();
    $results['fatal_trace'] = array_slice(array_map(function($t) {
        return ($t['file'] ?? '?') . ':' . ($t['line'] ?? '?');
    }, $e->getTrace()), 0, 10);
}

echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
