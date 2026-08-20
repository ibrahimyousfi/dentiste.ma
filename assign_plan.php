<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$org = App\Models\Organization::first();
if($org) {
    App\Models\Subscription::updateOrCreate(
        ['organization_id' => $org->id],
        [
            'subscription_plan_id' => 2, // Pro
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addYear()
        ]
    );
    echo "Assigned Pro plan to organization.\n";
} else {
    echo "No organization found.\n";
}
