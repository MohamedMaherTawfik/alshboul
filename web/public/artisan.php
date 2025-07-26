<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();




\Artisan::call('config:clear');
echo "<pre>" . \Artisan::output() . "</pre>";

\Artisan::call('cache:clear');
echo "<pre>" . \Artisan::output() . "</pre>";

\Artisan::call('route:clear');
echo "<pre>" . \Artisan::output() . "</pre>";

\Artisan::call('view:clear');
echo "<pre>" . \Artisan::output() . "</pre>";


echo "Cleared config and cache!";
