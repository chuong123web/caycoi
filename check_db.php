<?php
// Simulate what the production app does - connect to production DB and load plants
try {
    $pdo = new PDO('mysql:host=tramway.proxy.rlwy.net;port=10558;dbname=railway', 'root', 'YacizdkgTjzkuDuzFdXjjxJpNGqwCXvd');
    echo "Connected OK\n\n";
    
    // Check plants
    $stmt = $pdo->query('SELECT COUNT(*) as cnt FROM plants WHERE is_active = 1');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Active plants: " . $row['cnt'] . "\n";
    
    // Check if Vite manifest exists
    $manifest = __DIR__ . '/public/build/manifest.json';
    echo "Vite manifest exists: " . (file_exists($manifest) ? 'YES' : 'NO') . "\n";
    if (file_exists($manifest)) {
        echo "Manifest content:\n" . file_get_contents($manifest) . "\n";
    }
    
    // Check storage link
    echo "Storage link exists: " . (file_exists(__DIR__ . '/public/storage') ? 'YES' : 'NO') . "\n";
    echo "Storage is link: " . (is_link(__DIR__ . '/public/storage') ? 'YES' : 'NO') . "\n";
    
} catch(Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
