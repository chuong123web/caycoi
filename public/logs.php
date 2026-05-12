<?php
header('Content-Type: text/plain');

$logFile = __DIR__.'/../storage/logs/laravel.log';

if (file_exists($logFile)) {
    // Get last 1000 lines
    $lines = file($logFile);
    $lastLines = array_slice($lines, -1000);
    echo implode("", $lastLines);
} else {
    echo "Log file does not exist at " . $logFile;
}
