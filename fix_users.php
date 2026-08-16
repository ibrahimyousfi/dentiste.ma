<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Organization;
use App\Models\User;

$orgs = Organization::all();
foreach ($orgs as $org) {
    if ($org->email) {
        $user = User::where('email', $org->email)->first();
        if ($user && !$user->organization_id) {
            $user->organization_id = $org->id;
            $user->save();
            echo "Fixed user {$user->name} for org {$org->name}\n";
        }
    }
}

// Fallback: If there are users created with other emails, just give them their own org based on some logic, or just assign them to the last org for test.
$users = User::whereNull('organization_id')->get();
foreach ($users as $user) {
    if (!$user->hasRole('Super Admin')) {
        // Just assign to the newest organization to fix the demo state
        $org = Organization::latest()->first();
        if ($org) {
            $user->organization_id = $org->id;
            $user->save();
            echo "Assigned orphan user {$user->name} to org {$org->name}\n";
        }
    }
}
echo "Done.\n";
