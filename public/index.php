<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Periksa apakah aplikasi dalam mode maintenance...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Daftarkan autoloader Composer...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel dan tangani request...
$app = require_once __DIR__.'/../bootstrap/app.php';

// Daftarkan middleware admin dan check.cart
$app->make('router')->aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);

$app->handleRequest(Request::capture());
