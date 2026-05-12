<?php
header('Content-Type: application/json');
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$action = $_GET['action'] ?? 'check';

if ($action === 'check') {
    // Show which media records have missing files
    $medias = \Spatie\MediaLibrary\MediaCollections\Models\Media::all();
    $results = ['total' => $medias->count(), 'orphaned' => [], 'valid' => []];
    foreach ($medias as $media) {
        $exists = file_exists($media->getPath());
        $info = [
            'id' => $media->id,
            'model' => $media->model_type . '#' . $media->model_id,
            'collection' => $media->collection_name,
            'file' => $media->file_name,
            'path' => $media->getPath(),
            'exists' => $exists,
        ];
        if ($exists) {
            $results['valid'][] = $info;
        } else {
            $results['orphaned'][] = $info;
        }
    }
    echo json_encode($results, JSON_PRETTY_PRINT);
    exit;
}

if ($action === 'cleanup') {
    // Delete orphaned media records (no physical file)
    $medias = \Spatie\MediaLibrary\MediaCollections\Models\Media::all();
    $deleted = 0;
    foreach ($medias as $media) {
        if (!file_exists($media->getPath())) {
            $media->delete();
            $deleted++;
        }
    }
    // Clear cache
    \Illuminate\Support\Facades\Cache::forget('global_plants');
    echo json_encode(['deleted_orphaned_records' => $deleted, 'cache_cleared' => true]);
    exit;
}
