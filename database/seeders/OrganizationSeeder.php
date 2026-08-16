<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Models\User;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organization::firstOrCreate(
            ['id' => 1],
            ['name' => 'Pearl Dental Care']
        );

        $user = User::first();
        if ($user) {
            $user->organization_id = $org->id;
            $user->save();
        }
    }
}
