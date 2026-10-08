<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if running on serverless environment (e.g. Vercel)
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $storagePath = '/tmp/storage';
    if (!is_dir($storagePath)) {
        @mkdir($storagePath, 0755, true);
        @mkdir($storagePath . '/framework/views', 0755, true);
        @mkdir($storagePath . '/framework/cache', 0755, true);
        @mkdir($storagePath . '/framework/sessions', 0755, true);
        @mkdir($storagePath . '/logs', 0755, true);
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
$autoloadPath = __DIR__.'/../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    $altPaths = [
        dirname(__DIR__).'/vendor/autoload.php',
        '/var/task/vpsmcu-laravel/vendor/autoload.php',
        '/var/task/user/vpsmcu-laravel/vendor/autoload.php',
    ];
    foreach ($altPaths as $alt) {
        if (file_exists($alt)) {
            $autoloadPath = $alt;
            break;
        }
    }
}
require $autoloadPath;

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
