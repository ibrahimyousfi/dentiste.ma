<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SubscriptionPlan::updateOrCreate(
            ['slug' => 'starter'],
            [
                'name' => 'Starter (Basic)',
                'price_monthly' => 29.99,
                'price_yearly' => 299.90,
                'limit_users' => 2, // 1 doctor, 1 secretary
                'limit_patients' => 300,
                'features' => [
                    'appointments' => true,
                    'dental_chart' => true,
                    'invoices' => true,
                    'whatsapp_notifications' => false,
                    'advanced_dental_chart' => false,
                    'inventory' => false,
                    'recalls' => false,
                    'laboratory' => false,
                ],
                'is_active' => true,
            ]
        );

        \App\Models\SubscriptionPlan::updateOrCreate(
            ['slug' => 'pro'],
            [
                'name' => 'Professional (Pro)',
                'price_monthly' => 79.99,
                'price_yearly' => 799.90,
                'limit_users' => 6, // 3 doctors, 3 staff
                'limit_patients' => null, // Unlimited
                'features' => [
                    'appointments' => true,
                    'dental_chart' => true,
                    'invoices' => true,
                    'whatsapp_notifications' => true,
                    'advanced_dental_chart' => true,
                    'inventory' => true,
                    'recalls' => true,
                    'laboratory' => false,
                ],
                'is_active' => true,
            ]
        );

        \App\Models\SubscriptionPlan::updateOrCreate(
            ['slug' => 'elite'],
            [
                'name' => 'Elite (Premium)',
                'price_monthly' => 149.99,
                'price_yearly' => 1499.90,
                'limit_users' => null, // Unlimited
                'limit_patients' => null, // Unlimited
                'features' => [
                    'appointments' => true,
                    'dental_chart' => true,
                    'invoices' => true,
                    'whatsapp_notifications' => true,
                    'advanced_dental_chart' => true,
                    'inventory' => true,
                    'recalls' => true,
                    'laboratory' => true,
                ],
                'is_active' => true,
            ]
        );
    }
}
