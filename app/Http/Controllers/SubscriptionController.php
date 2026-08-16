<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $organization = auth()->user()->organization;
        
        $plans = [
            'Basic' => [
                'price' => 29,
                'features' => ['Up to 500 Patients', 'Basic Appointments', 'Standard Support', '1 Doctor Account'],
                'color' => 'gray'
            ],
            'Pro' => [
                'price' => 79,
                'features' => ['Unlimited Patients', 'Advanced Analytics', 'Priority Support', 'Up to 3 Doctors', 'Voice Dictation AI'],
                'color' => '[#39D3C4]'
            ],
            'Premium' => [
                'price' => 149,
                'features' => ['Everything in Pro', 'Unlimited Doctors', 'Smart Inventory Management', 'Dedicated Account Manager', 'Custom Integrations'],
                'color' => 'indigo'
            ]
        ];
        
        return view('clinic.subscription.index', compact('organization', 'plans'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'plan' => 'required|string|in:Basic,Pro,Premium'
        ]);
        
        $organization = auth()->user()->organization;
        
        // Simulate processing payment
        sleep(1);
        
        // Update subscription
        $organization->update([
            'subscription_plan' => $validated['plan'],
            'subscription_ends_at' => now()->addMonth(), // Assuming monthly billing
        ]);
        
        return redirect()->back()->with('success', "Successfully upgraded to the {$validated['plan']} Plan! Thank you for subscribing.");
    }
}
