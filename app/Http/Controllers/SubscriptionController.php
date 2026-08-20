<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $organization = auth()->user()->organization;
        $currentSubscription = $organization->subscription;
        
        $plans = \App\Models\SubscriptionPlan::where('is_active', true)->get();
        
        // Calculate days
        $daysElapsed = 0;
        $daysRemaining = 0;
        $totalDays = 0;
        $percentage = 0;

        if ($currentSubscription && $currentSubscription->starts_at && $currentSubscription->ends_at) {
            $start = \Carbon\Carbon::parse($currentSubscription->starts_at);
            $end = \Carbon\Carbon::parse($currentSubscription->ends_at);
            $now = now();
            
            $totalDays = (int) ceil($start->diffInDays($end)) ?: 1;
            
            if ($now->greaterThanOrEqualTo($end)) {
                $daysElapsed = $totalDays;
                $daysRemaining = 0;
                $percentage = 100;
            } else {
                $daysElapsed = (int) floor($start->diffInDays($now));
                $daysRemaining = (int) ceil($now->diffInDays($end));
                $percentage = min(100, max(0, ($daysElapsed / $totalDays) * 100));
            }
        }

        $pendingRequest = \App\Models\SubscriptionRequest::where('organization_id', $organization->id)
            ->where('status', 'pending')
            ->first();
        
        return view('clinic.subscription.index', compact('organization', 'currentSubscription', 'plans', 'daysElapsed', 'daysRemaining', 'totalDays', 'percentage', 'pendingRequest'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'payment_method' => 'nullable|string'
        ]);
        
        $organization = auth()->user()->organization;
        
        // Check if there is already a pending request
        $existing = \App\Models\SubscriptionRequest::where('organization_id', $organization->id)
            ->where('status', 'pending')
            ->first();
            
        if ($existing) {
            return redirect()->back()->with('error', 'You already have a pending upgrade request. Please wait for admin approval.');
        }
        
        \App\Models\SubscriptionRequest::create([
            'organization_id' => $organization->id,
            'subscription_plan_id' => $validated['plan_id'],
            'status' => 'pending',
            'payment_method' => $request->payment_method ?? 'bank_transfer',
        ]);
        
        return redirect()->back()->with('success', "Your upgrade request has been sent to the administration. We will activate your new plan once the payment is verified.");
    }
}
