<?php
// Emergency seeder for Railway production
// Usage: https://your-app.up.railway.app/seed.php
header('Content-Type: application/json');
$results = [];

try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    // Clear all caches first
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    $results['cache_cleared'] = '✅';

    // Run RoleSeeder
    ob_start();
    Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'Database\Seeders\RoleSeeder', '--force' => true]);
    $results['roles'] = trim(ob_get_clean() . Illuminate\Support\Facades\Artisan::output());

    // Run PlantSeeder
    ob_start();
    Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'Database\Seeders\PlantSeeder', '--force' => true]);
    $results['plants'] = trim(ob_get_clean() . Illuminate\Support\Facades\Artisan::output());

    // Verify
    $results['plant_count'] = \App\Models\Plant::count();
    $results['active_plants'] = \App\Models\Plant::where('is_active', true)->count();
    $results['admin_exists'] = \App\Models\User::where('email', 'admin@verdant.vn')->exists();

} catch (\Throwable $e) {
    $results['error'] = $e->getMessage();
    $results['file'] = $e->getFile() . ':' . $e->getLine();
}

echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
