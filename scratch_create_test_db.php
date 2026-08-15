<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
\Illuminate\Support\Facades\DB::statement('CREATE DATABASE IF NOT EXISTS ayurveda_test;');
echo "ayurveda_test DATABASE READY\n";
