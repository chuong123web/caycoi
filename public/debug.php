<?php
header('Content-Type: application/json');
$results = [];

try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    // Catch boot errors
    try {
        $app->boot();
        $results['boot'] = 'OK';
    } catch (\Throwable $e) {
        $results['boot'] = 'FAIL';
        $results['boot_error'] = $e->getMessage();
        $results['boot_trace'] = array_slice(array_map(function($t) {
            return ($t['file'] ?? '?') . ':' . ($t['line'] ?? '?');
        }, $e->getTrace()), 0, 15);
    }
    
    $results['php_version'] = phpversion();
    
    // Check plants
    try {
        $results['plants_count'] = \App\Models\Plant::count();
    } catch (\Throwable $e) {
        $results['plants'] = 'FAIL: ' . $e->getMessage();
    }

} catch (\Throwable $e) {
    $results['fatal'] = $e->getMessage();
    $results['fatal_file'] = $e->getFile() . ':' . $e->getLine();
    $results['fatal_trace'] = array_slice(array_map(function($t) {
        return ($t['file'] ?? '?') . ':' . ($t['line'] ?? '?');
    }, $e->getTrace()), 0, 15);
}

echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
