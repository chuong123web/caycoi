<?php
// Direct test of the Livewire upload endpoint
header('Content-Type: text/plain');

// Create a small test image
$img = imagecreatetruecolor(100, 100);
$green = imagecolorallocate($img, 0, 128, 0);
imagefill($img, 0, 0, $green);
$tmpFile = tempnam(sys_get_temp_dir(), 'img');
imagejpeg($img, $tmpFile, 90);
imagedestroy($img);

echo "=== Test Image Created ===\n";
echo "Path: $tmpFile\n";
echo "Size: " . filesize($tmpFile) . " bytes\n\n";

// Test 1: Try to directly call the upload controller
echo "=== Testing Livewire Upload Handler ===\n";
try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    // Create a fake upload request
    $uploadedFile = new \Illuminate\Http\UploadedFile(
        $tmpFile,
        'test_image.jpg',
        'image/jpeg',
        null,
        true // test mode
    );

    // Try to store through Livewire's mechanism
    $disk = \Illuminate\Support\Facades\Storage::disk('local');
    $path = $disk->putFile('livewire-tmp', $uploadedFile);
    echo "Upload to local disk: SUCCESS\n";
    echo "Stored at: $path\n";
    echo "Full path: " . $disk->path($path) . "\n";
    echo "Exists: " . ($disk->exists($path) ? 'yes' : 'no') . "\n";
    $disk->delete($path);
    echo "Deleted: yes\n\n";

    // Test public disk too
    $disk2 = \Illuminate\Support\Facades\Storage::disk('public');
    $path2 = $disk2->putFile('test-uploads', $uploadedFile);
    echo "Upload to public disk: SUCCESS\n";
    echo "Stored at: $path2\n";
    echo "URL: " . $disk2->url($path2) . "\n";
    echo "Accessible from web: " . (file_exists(public_path('storage/' . $path2)) ? 'yes' : 'no') . "\n";
    $disk2->delete($path2);
    
    // Test Spatie Media Library directly
    echo "\n=== Testing Spatie Media Library ===\n";
    $plant = \App\Models\Plant::first();
    if ($plant) {
        // Create a test image file
        $testImgPath = storage_path('app/test_spatie.jpg');
        copy($tmpFile, $testImgPath);
        
        try {
            $plant->addMedia($testImgPath)
                ->toMediaCollection('thumbnail');
            echo "Spatie addMedia: SUCCESS\n";
            echo "Media count: " . $plant->media()->count() . "\n";
            $media = $plant->getFirstMedia('thumbnail');
            if ($media) {
                echo "Media URL: " . $media->getUrl() . "\n";
                echo "Media path: " . $media->getPath() . "\n";
                echo "Media file exists: " . (file_exists($media->getPath()) ? 'yes' : 'no') . "\n";
            }
        } catch (\Throwable $e) {
            echo "Spatie addMedia: FAIL - " . $e->getMessage() . "\n";
            echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
            // Show first 5 trace lines
            $trace = $e->getTrace();
            for ($i = 0; $i < min(5, count($trace)); $i++) {
                echo "  " . ($trace[$i]['file'] ?? '?') . ":" . ($trace[$i]['line'] ?? '?') . "\n";
            }
        }
    }

} catch (\Throwable $e) {
    echo "FATAL: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    $trace = $e->getTrace();
    for ($i = 0; $i < min(5, count($trace)); $i++) {
        echo "  " . ($trace[$i]['file'] ?? '?') . ":" . ($trace[$i]['line'] ?? '?') . "\n";
    }
}

@unlink($tmpFile);
