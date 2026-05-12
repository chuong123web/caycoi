<?php
// Test upload endpoint to diagnose Livewire upload issues
header('Content-Type: application/json');
$results = [];

try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    // Test 1: Create livewire-tmp dir on local disk
    try {
        $disk = \Illuminate\Support\Facades\Storage::disk('local');
        $disk->put('livewire-tmp/test_upload.txt', 'hello world');
        $results['local_disk_write'] = $disk->exists('livewire-tmp/test_upload.txt');
        $results['local_disk_path'] = $disk->path('livewire-tmp/test_upload.txt');
        $results['local_disk_path_exists'] = file_exists($disk->path('livewire-tmp/test_upload.txt'));
        $disk->delete('livewire-tmp/test_upload.txt');
    } catch (\Throwable $e) {
        $results['local_disk_write'] = 'FAIL: ' . $e->getMessage();
    }

    // Test 2: Write a fake image to public disk (simulating Spatie)
    try {
        $disk = \Illuminate\Support\Facades\Storage::disk('public');
        // Create a 1x1 pixel PNG
        $img = imagecreatetruecolor(1, 1);
        ob_start();
        imagepng($img);
        $imgData = ob_get_clean();
        imagedestroy($img);

        $disk->put('test_image.png', $imgData);
        $results['public_disk_image_write'] = $disk->exists('test_image.png');
        $results['public_disk_image_url'] = $disk->url('test_image.png');
        $results['public_disk_image_path'] = $disk->path('test_image.png');
        $results['public_disk_image_accessible'] = file_exists(public_path('storage/test_image.png'));
        $disk->delete('test_image.png');
        $results['gd_working'] = true;
    } catch (\Throwable $e) {
        $results['public_disk_image_write'] = 'FAIL: ' . $e->getMessage();
    }

    // Test 3: Simulate Spatie Media Library addMedia
    try {
        $plant = \App\Models\Plant::first();
        if ($plant) {
            $results['plant'] = $plant->name;
            $results['media_count'] = $plant->media()->count();
            $results['spatie_disk'] = config('media-library.disk_name', 'public');
            
            // Check if media-library config exists
            $results['media_config_exists'] = file_exists(config_path('media-library.php'));
        }
    } catch (\Throwable $e) {
        $results['spatie_test'] = 'FAIL: ' . $e->getMessage();
    }

    // Test 4: Check if the upload-file endpoint would work by checking middleware
    try {
        $routes = app('router')->getRoutes();
        foreach ($routes as $route) {
            if (str_contains($route->uri(), 'upload-file')) {
                $results['upload_route'] = [
                    'uri' => $route->uri(),
                    'methods' => $route->methods(),
                    'middleware' => $route->middleware(),
                    'action' => $route->getActionName(),
                ];
            }
        }
    } catch (\Throwable $e) {
        $results['route_check'] = 'FAIL: ' . $e->getMessage();
    }

    // Test 5: Check if session works (needed for CSRF)
    try {
        $results['session_driver'] = config('session.driver');
        $results['session_table'] = config('session.table');
        // Try to verify sessions table exists
        $sessionTableExists = \Illuminate\Support\Facades\Schema::hasTable(config('session.table', 'sessions'));
        $results['session_table_exists'] = $sessionTableExists;
    } catch (\Throwable $e) {
        $results['session_check'] = 'FAIL: ' . $e->getMessage();
    }

    // Test 6: Check CSRF config
    $results['csrf_cookie'] = config('session.cookie');

    // Test 7: Force-enable logging so we can see errors
    try {
        \Illuminate\Support\Facades\Log::info('Test log from upload_test.php');
        $logPath = storage_path('logs/laravel.log');
        $results['log_path'] = $logPath;
        $results['log_exists'] = file_exists($logPath);
        $results['log_writable'] = is_writable(dirname($logPath));
    } catch (\Throwable $e) {
        $results['logging'] = 'FAIL: ' . $e->getMessage();
    }

} catch (\Throwable $e) {
    $results['fatal'] = $e->getMessage();
    $results['trace'] = $e->getFile() . ':' . $e->getLine();
}

echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
