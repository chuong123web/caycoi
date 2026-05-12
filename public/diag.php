<?php
header('Content-Type: application/json');
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$results = [];

// 1. Check symlink
$symlinkPath = public_path('storage');
$results['symlink_exists'] = file_exists($symlinkPath);
$results['symlink_is_link'] = is_link($symlinkPath);
if (is_link($symlinkPath)) {
    $results['symlink_target'] = readlink($symlinkPath);
    $results['symlink_target_exists'] = is_dir(readlink($symlinkPath));
}

// 2. Check storage directory
$storagePath = storage_path('app/public');
$results['storage_public_exists'] = is_dir($storagePath);
$results['storage_public_writable'] = is_writable($storagePath);

// 3. List files in storage/app/public
$results['storage_files'] = [];
if (is_dir($storagePath)) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storagePath));
    $count = 0;
    foreach ($iterator as $file) {
        if ($file->isFile() && $count < 30) {
            $results['storage_files'][] = str_replace($storagePath, '', $file->getPathname());
            $count++;
        }
    }
}

// 4. Check Railway volume env vars
$results['volume_name'] = env('RAILWAY_VOLUME_NAME', 'NOT SET');
$results['volume_mount'] = env('RAILWAY_VOLUME_MOUNT_PATH', 'NOT SET');

// 5. Check all plants with media
$plants = \App\Models\Plant::all();
$results['plants'] = [];
foreach ($plants as $plant) {
    $media = $plant->getFirstMedia('thumbnail') ?: $plant->getFirstMedia('images');
    $info = [
        'name' => $plant->name,
        'slug' => $plant->slug,
        'has_media' => !!$media,
        'image_url' => $plant->image_url,
    ];
    if ($media) {
        $info['media_id'] = $media->id;
        $info['media_file'] = $media->file_name;
        $info['media_path'] = $media->getPath();
        $info['media_exists'] = file_exists($media->getPath());
        $info['media_url'] = $media->getUrl();
    }
    $results['plants'][] = $info;
}

// 6. Count total media records
$results['total_media_records'] = \Spatie\MediaLibrary\MediaCollections\Models\Media::count();

echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
