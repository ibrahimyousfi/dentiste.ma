<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach (App\Models\User::all() as $user) {
    echo $user->id . ':' . $user->name . ' - ' . $user->roles->pluck('name')->implode(',') . "\n";
}
