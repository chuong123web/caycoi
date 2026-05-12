<?php
// Step 1: Enable logging, Step 2: Show recent logs
header('Content-Type: application/json');

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$action = $_GET['action'] ?? 'logs';

if ($action === 'init') {
    // Create log file
    $logPath = storage_path('logs/laravel.log');
    @mkdir(dirname($logPath), 0755, true);
    file_put_contents($logPath, "[" . date('Y-m-d H:i:s') . "] Log initialized\n");
    echo json_encode(['status' => 'Log file created', 'path' => $logPath]);
    exit;
}

if ($action === 'logs') {
    $logPath = storage_path('logs/laravel.log');
    if (!file_exists($logPath)) {
        echo json_encode(['error' => 'No log file. Visit ?action=init first']);
        exit;
    }
    $content = file_get_contents($logPath);
    $lines = explode("\n", $content);
    // Get last 100 lines
    $lastLines = array_slice($lines, -100);
    echo json_encode([
        'total_lines' => count($lines),
        'file_size' => filesize($logPath),
        'lines' => array_values(array_filter($lastLines, fn($l) => trim($l) !== ''))
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($action === 'clear') {
    $logPath = storage_path('logs/laravel.log');
    file_put_contents($logPath, "[" . date('Y-m-d H:i:s') . "] Log cleared\n");
    echo json_encode(['status' => 'Log cleared']);
    exit;
}

echo json_encode(['error' => 'Unknown action. Use ?action=init, ?action=logs, or ?action=clear']);
