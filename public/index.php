<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// FORCE DEBUG MODE FOR TROUBLESHOOTING
putenv('APP_DEBUG=true');
$_ENV['APP_DEBUG'] = 'true';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Force debug config
$app->detectEnvironment(function() { return 'production'; });
$app->booted(function($app) {
    config(['app.debug' => true]);
});

$app->handleRequest(Request::capture());
