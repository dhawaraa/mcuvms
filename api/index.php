<?php
// Determine task root path
$rootDir = realpath(__DIR__ . '/..');
$autoloadPath = $rootDir . '/mcuvms-laravel/vendor/autoload.php';

if (!file_exists($autoloadPath)) {
    // Check possible alternative paths in Vercel lambda
    $candidates = [
        __DIR__ . '/../mcuvms-laravel/vendor/autoload.php',
        dirname(__DIR__) . '/mcuvms-laravel/vendor/autoload.php',
        '/var/task/mcuvms-laravel/vendor/autoload.php',
        '/var/task/user/mcuvms-laravel/vendor/autoload.php',
    ];
    $found = false;
    foreach ($candidates as $cand) {
        if (file_exists($cand)) {
            $autoloadPath = $cand;
            $found = true;
            break;
        }
    }
    if (!$found) {
        header('Content-Type: text/plain; charset=utf-8');
        echo "DEBUG PATH INFO:\n";
        echo "__DIR__: " . __DIR__ . "\n";
        echo "pwd: " . getcwd() . "\n";
        echo "rootDir: " . $rootDir . "\n";
        echo "Directory listing of __DIR__:\n";
        print_r(scandir(__DIR__));
        echo "Directory listing of parent:\n";
        print_r(scandir(__DIR__ . '/..'));
        if (file_exists(__DIR__ . '/../mcuvms-laravel')) {
            echo "Directory listing of mcuvms-laravel:\n";
            print_r(scandir(__DIR__ . '/../mcuvms-laravel'));
        }
        exit;
    }
}

// Forward to public/index.php
require __DIR__ . '/../mcuvms-laravel/public/index.php';

