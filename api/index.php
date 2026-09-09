<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Setup writable storage directory in /tmp for Vercel Serverless environment
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/app/public',
    '/tmp/storage/logs',
    '/tmp/certs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Copy SSL CA certificate to /tmp if it exists
$certSource = __DIR__ . '/../storage/certs/ca.pem';
if (file_exists($certSource) && !file_exists('/tmp/certs/ca.pem')) {
    copy($certSource, '/tmp/certs/ca.pem');
}

// Maintenance mode check
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register autoloader
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Set storage path to writable /tmp
$app->useStoragePath('/tmp/storage');

// Handle request
$app->handleRequest(Request::capture());
