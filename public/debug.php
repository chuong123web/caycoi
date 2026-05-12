<?php
// Fix debug.php to properly bootstrap Laravel so it doesn't fail on app('files')
header('Content-Type: application/json');
$results = [];

try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    // Proper bootstrap sequence
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    $results['boot'] = 'OK';
    $results['php_version'] = phpversion();
    
    // Check plants
    try {
        $results['plants_count'] = \App\Models\Plant::count();
        $results['active_plants'] = \App\Models\Plant::where('is_active', true)->count();
    } catch (\Throwable $e) {
        $results['plants'] = 'FAIL: ' . $e->getMessage();
    }

} catch (\Throwable $e) {
    $results['fatal'] = $e->getMessage();
    $results['fatal_file'] = $e->getFile() . ':' . $e->getLine();
    $results['fatal_trace'] = array_slice(array_map(function($t) {
        return ($t['file'] ?? '?') . ':' . ($t['line'] ?? '?');
    }, $e->getTrace()), 0, 10);
}

echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
