<?php
// Run seeder directly on server - access via /seed.php
// DELETE THIS FILE AFTER USE!
header('Content-Type: application/json');

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle($request = Illuminate\Http\Request::capture());

$results = [];

try {
    // Run RoleSeeder
    Illuminate\Support\Facades\Artisan::call('db:seed', [
        '--class' => 'Database\\Seeders\\RoleSeeder',
        '--force' => true,
    ]);
    $results['roles'] = '✅ ' . trim(Illuminate\Support\Facades\Artisan::output());

    // Run PlantSeeder
    Illuminate\Support\Facades\Artisan::call('db:seed', [
        '--class' => 'Database\\Seeders\\PlantSeeder',
        '--force' => true,
    ]);
    $results['plants'] = '✅ ' . trim(Illuminate\Support\Facades\Artisan::output());

    // Verify
    $results['plant_count'] = App\Models\Plant::count();
    $results['active_plants'] = App\Models\Plant::where('is_active', true)->count();
    $results['admin_exists'] = App\Models\User::where('email', 'admin@verdant.vn')->exists();

    // Clear cache so new data shows
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    $results['cache_cleared'] = '✅';

} catch (\Throwable $e) {
    $results['error'] = $e->getMessage();
    $results['file'] = $e->getFile() . ':' . $e->getLine();
}

echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
