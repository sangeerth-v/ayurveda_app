<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Admin;
$a = Admin::find(2);
if ($a) {
    echo "ID: 2 | Email: {$a->email} | Password: {$a->password}\n";
}
