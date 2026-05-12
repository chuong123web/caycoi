<?php
header('Content-Type: application/json');
$results = [];

try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    // 1. APP_URL
    $results['app_url'] = config('app.url');
    $results['app_env'] = config('app.env');
    $results['app_debug'] = config('app.debug');

    // 2. Session driver
    $results['session_driver'] = config('session.driver');
    $results['session_path'] = config('session.files');

    // 3. Filesystem
    $results['filesystem_default'] = config('filesystems.default');
    
    // 4. Livewire temp upload disk
    $results['livewire_upload_disk'] = config('livewire.temporary_file_upload.disk') ?: 'default (local)';
    $results['livewire_upload_rules'] = config('livewire.temporary_file_upload.rules');
    $results['livewire_upload_dir'] = config('livewire.temporary_file_upload.directory') ?: 'livewire-tmp';

    // 5. Test storage write
    $storagePath = storage_path('app/livewire-tmp');
    if (!is_dir($storagePath)) {
        @mkdir($storagePath, 0755, true);
    }
    $results['livewire_tmp_exists'] = is_dir($storagePath);
    $results['livewire_tmp_writable'] = is_writable($storagePath);

    // 6. Test storage facade
    try {
        \Illuminate\Support\Facades\Storage::disk('local')->put('livewire-tmp/test.txt', 'test');
        $results['storage_write'] = \Illuminate\Support\Facades\Storage::disk('local')->exists('livewire-tmp/test.txt');
        \Illuminate\Support\Facades\Storage::disk('local')->delete('livewire-tmp/test.txt');
    } catch (\Throwable $e) {
        $results['storage_write'] = 'FAIL: ' . $e->getMessage();
    }

    // 7. Test public disk
    try {
        \Illuminate\Support\Facades\Storage::disk('public')->put('test_upload.txt', 'test');
        $results['public_disk_write'] = \Illuminate\Support\Facades\Storage::disk('public')->exists('test_upload.txt');
        \Illuminate\Support\Facades\Storage::disk('public')->delete('test_upload.txt');
    } catch (\Throwable $e) {
        $results['public_disk_write'] = 'FAIL: ' . $e->getMessage();
    }

    // 8. Check symlink
    $symlinkPath = public_path('storage');
    $results['storage_symlink_exists'] = file_exists($symlinkPath);
    $results['storage_symlink_is_link'] = is_link($symlinkPath);
    if (is_link($symlinkPath)) {
        $results['storage_symlink_target'] = readlink($symlinkPath);
    }

    // 9. Check media-library disk config
    $results['media_disk'] = config('media-library.disk_name', 'public (default)');

    // 10. Recent log errors
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $logContent = file_get_contents($logFile);
        $lines = explode("\n", $logContent);
        $lastLines = array_slice($lines, -30);
        // Filter for errors
        $errors = array_filter($lastLines, function($line) {
            return str_contains($line, 'ERROR') || str_contains($line, 'error') || str_contains($line, 'Exception') || str_contains($line, 'upload');
        });
        $results['recent_errors'] = array_values($errors);
    } else {
        $results['log_file'] = 'not found';
    }

    // 11. Check CSRF/Session
    $results['session_save_path'] = session_save_path();
    $results['tmp_dir'] = sys_get_temp_dir();
    $results['tmp_writable'] = is_writable(sys_get_temp_dir());

    // 12. Check Livewire routes
    try {
        $routes = app('router')->getRoutes();
        $lwRoutes = [];
        foreach ($routes as $route) {
            $uri = $route->uri();
            if (str_contains($uri, 'livewire')) {
                $lwRoutes[] = $route->methods()[0] . ' ' . $uri;
            }
        }
        $results['livewire_routes'] = $lwRoutes;
    } catch (\Throwable $e) {
        $results['livewire_routes'] = 'FAIL: ' . $e->getMessage();
    }

} catch (\Throwable $e) {
    $results['fatal'] = $e->getMessage();
    $results['file'] = $e->getFile() . ':' . $e->getLine();
}

echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
