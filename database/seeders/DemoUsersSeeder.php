<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Super Admin
        $superAdmin = User::firstOrCreate([
            'email' => 'admin@dental.com',
        ], [
            'name' => 'System Admin',
            'password' => Hash::make('password123'),
        ]);
        $superAdmin->assignRole('Super Admin');

        // 2. Create a Demo Organization (Clinic)
        $clinic = Organization::firstOrCreate([
            'name' => 'Smile Care Clinic',
        ], [
            'email' => 'contact@smilecare.com',
            'phone' => '0500000000',
        ]);

        // 3. Create Clinic Owner
        $owner = User::firstOrCreate([
            'email' => 'doctor@dental.com',
        ], [
            'name' => 'Dr. Ahmed',
            'password' => Hash::make('password123'),
            'organization_id' => $clinic->id,
        ]);
        $owner->assignRole('Clinic Owner');

        // 4. Create Secretary
        $secretary = User::firstOrCreate([
            'email' => 'secretary@dental.com',
        ], [
            'name' => 'Sarah (Reception)',
            'password' => Hash::make('password123'),
            'organization_id' => $clinic->id,
        ]);
        $secretary->assignRole('Secretary');

        // 5. Create a Patient for testing the portal
        $patient = Patient::firstOrCreate([
            'phone' => '0612345678',
        ], [
            'organization_id' => $clinic->id,
            'patient_code' => 'PT-12345',
            'first_name' => 'Youssef',
            'last_name' => 'Test',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male',
        ]);
    }
}
