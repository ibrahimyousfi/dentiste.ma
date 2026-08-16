<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LabPartner;

class LabPartnerSeeder extends Seeder
{
    public function run(): void
    {
        LabPartner::firstOrCreate(
            ['email' => 'contact@premiumdental.com'],
            [
                'organization_id' => 1,
                'name' => 'Premium Dental Lab',
                'contact_person' => 'Ahmed Youssef',
                'phone' => '+123456789',
                'address' => '123 Medical Hub, City Center'
            ]
        );
    }
}
