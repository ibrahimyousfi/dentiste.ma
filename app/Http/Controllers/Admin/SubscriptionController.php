<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::all();
        $subscriptions = Subscription::with(['organization', 'plan'])->latest()->paginate(20);
        $pendingRequests = \App\Models\SubscriptionRequest::with(['organization', 'plan'])->where('status', 'pending')->latest()->get();

        return view('admin.subscriptions.index', compact('plans', 'subscriptions', 'pendingRequests'));
    }

    public function updatePlan(Request $request, Subscription $subscription)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $subscription->update([
            'subscription_plan_id' => $request->plan_id,
            'status' => 'active',
        ]);

        return back()->with('success', 'Subscription plan updated successfully.');
    }

    public function extend(Request $request, Subscription $subscription)
    {
        $request->validate([
            'days' => 'required|integer|min:1',
        ]);

        $currentEnd = $subscription->ends_at && $subscription->ends_at->isFuture() 
            ? $subscription->ends_at 
            : now();

        $subscription->update([
            'ends_at' => $currentEnd->addDays($request->days),
            'status' => 'active',
        ]);

        return back()->with('success', "Subscription extended by {$request->days} days.");
    }

    public function suspend(Subscription $subscription)
    {
        $newStatus = $subscription->status === 'suspended' ? 'active' : 'suspended';
        
        $subscription->update([
            'status' => $newStatus,
        ]);

        return back()->with('success', "Subscription status changed to {$newStatus}.");
    }

    public function approveRequest(\App\Models\SubscriptionRequest $request)
    {
        if ($request->status !== 'pending') {
            return back()->with('error', 'Request is already processed.');
        }

        // Update the clinic's subscription
        $subscription = Subscription::firstOrNew(['organization_id' => $request->organization_id]);
        $subscription->subscription_plan_id = $request->subscription_plan_id;
        $subscription->status = 'active';
        $subscription->starts_at = now();
        $subscription->ends_at = now()->addDays(30); // E.g., 30 days
        $subscription->save();

        $request->update(['status' => 'approved']);

        return back()->with('success', 'Upgrade request approved successfully. Clinic is now on the new plan.');
    }

    public function rejectRequest(\App\Models\SubscriptionRequest $request)
    {
        if ($request->status !== 'pending') {
            return back()->with('error', 'Request is already processed.');
        }

        $request->update(['status' => 'rejected']);

        return back()->with('success', 'Upgrade request rejected.');
    }
}
