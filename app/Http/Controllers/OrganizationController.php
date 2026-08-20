<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the organizations.
     */
    public function index()
    {
        $organizations = Organization::withCount(['users', 'patients'])
            ->withSum('payments', 'amount')
            ->latest()
            ->get();
            
        $pendingRequests = \App\Models\SubscriptionRequest::with(['organization', 'plan'])
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        return view('admin.organizations.index', compact('organizations', 'pendingRequests'));
    }

    /**
     * Show the form for creating a new organization.
     */
    public function create()
    {
        return view('admin.organizations.create');
    }

    /**
     * Store a newly created organization and its owner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'clinic_name' => ['required', 'string', 'max:255'],
            'clinic_email' => ['nullable', 'email', 'max:255'],
            'clinic_phone' => ['nullable', 'string', 'max:255'],
            'owner_name' => ['required', 'string', 'max:255'],
            'owner_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::transaction(function () use ($request) {
            // 1. Create Organization
            $organization = Organization::create([
                'name' => $request->clinic_name,
                'email' => $request->clinic_email,
                'phone' => $request->clinic_phone,
            ]);

            // 2. Create Owner User
            $owner = User::create([
                'name' => $request->owner_name,
                'email' => $request->owner_email,
                'password' => Hash::make($request->password),
                'organization_id' => $organization->id,
            ]);

            // 3. Assign Clinic Owner Role
            $owner->assignRole('Clinic Owner');

            // 4. Create default Subscription (Starter - 14 Days Trial)
            $starterPlan = \App\Models\SubscriptionPlan::where('slug', 'starter')->first();
            if ($starterPlan) {
                \App\Models\Subscription::create([
                    'organization_id' => $organization->id,
                    'subscription_plan_id' => $starterPlan->id,
                    'status' => 'active',
                    'starts_at' => now(),
                    'ends_at' => now()->addDays(14),
                ]);
            }
        });

        return redirect()->route('admin.organizations.index')->with('success', 'Clinic created successfully!');
    }

    public function show($id)
    {
        $organization = Organization::with(['users', 'payments', 'patients'])->findOrFail($id);
        return view('admin.organizations.show', compact('organization'));
    }

    public function edit($id)
    {
        $organization = Organization::findOrFail($id);
        $plans = \App\Models\SubscriptionPlan::all();
        $currentPlanId = $organization->subscription ? $organization->subscription->subscription_plan_id : null;
        return view('admin.organizations.edit', compact('organization', 'plans', 'currentPlanId'));
    }

    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'subscription_plan_id' => ['required', 'exists:subscription_plans,id'],
        ]);

        $organization->update($request->only('name', 'email', 'phone', 'address'));

        // Update or Create Subscription
        if ($organization->subscription) {
            $organization->subscription->update([
                'subscription_plan_id' => $request->subscription_plan_id,
            ]);
        } else {
            \App\Models\Subscription::create([
                'organization_id' => $organization->id,
                'subscription_plan_id' => $request->subscription_plan_id,
                'status' => 'active',
                'starts_at' => now(),
            ]);
        }

        return redirect()->route('admin.organizations.index')->with('success', 'Clinic updated successfully!');
    }

    public function suspend($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->status = $organization->status === 'active' ? 'suspended' : 'active';
        $organization->save();
        
        $message = $organization->status === 'active' ? 'Clinic activated.' : 'Clinic suspended.';
        return redirect()->route('admin.organizations.index')->with('success', $message);
    }

}
