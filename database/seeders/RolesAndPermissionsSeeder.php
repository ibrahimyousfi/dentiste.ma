<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            // Super Admin Permissions
            'manage global system',
            'manage organizations',
            
            // Clinic Owner Permissions
            'manage clinic settings',
            'manage clinic staff',
            
            // Shared Staff Permissions (Owner + Secretary)
            'manage appointments',
            'manage patients',
            'manage payments',
            'view clinic reports',
            
            // Patient Permissions
            'view own records',
            'book own appointments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign created permissions

        // 1. Super Admin
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $roleSuperAdmin->givePermissionTo(Permission::all());

        // 2. Clinic Owner
        $roleClinicOwner = Role::firstOrCreate(['name' => 'Clinic Owner']);
        $roleClinicOwner->givePermissionTo([
            'manage clinic settings',
            'manage clinic staff',
            'manage appointments',
            'manage patients',
            'manage payments',
            'view clinic reports',
        ]);

        // 3. Secretary
        $roleSecretary = Role::firstOrCreate(['name' => 'Secretary']);
        $roleSecretary->givePermissionTo([
            'manage appointments',
            'manage patients',
            'manage payments',
            // Secretary does not manage clinic settings or staff
        ]);

        // 4. Patient
        $rolePatient = Role::firstOrCreate(['name' => 'Patient']);
        $rolePatient->givePermissionTo([
            'view own records',
            'book own appointments',
        ]);
    }
}
