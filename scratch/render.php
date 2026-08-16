<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::first();
Auth::login($user);

$html = view('patients.dental-chart', [
    'patient' => App\Models\Patient::first(),
    'treatmentCatalogs' => collect(),
    'isChild' => false,
    'findings' => []
])->render();

file_put_contents('test_render.html', $html);
echo "Rendered length: " . strlen($html) . "\n";
