<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::orderBy('price_monthly')->get();

        return view('admin.subscription_plans.index', compact('plans'));
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscription_plans.edit', compact('subscriptionPlan'));
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_monthly' => 'required|numeric|min:0',
            'price_yearly' => 'required|numeric|min:0',
            'limit_users' => 'nullable|integer|min:1',
            'limit_patients' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'features' => 'array',
        ]);

        // Default all features to false if not present, then set present ones to true
        $allFeatures = [
            'appointments' => false,
            'dental_chart' => false,
            'invoices' => false,
            'whatsapp_notifications' => false,
            'advanced_dental_chart' => false,
            'inventory' => false,
            'recalls' => false,
            'laboratory' => false,
        ];

        if (isset($validated['features'])) {
            foreach ($validated['features'] as $feature => $value) {
                $allFeatures[$feature] = true;
            }
        }

        $validated['features'] = $allFeatures;
        $validated['is_active'] = $request->has('is_active');

        $subscriptionPlan->update($validated);

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Plan updated successfully!');
    }
}
