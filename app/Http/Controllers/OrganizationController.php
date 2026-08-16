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
        return view('admin.organizations.index', compact('organizations'));
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
        return view('admin.organizations.edit', compact('organization'));
    }

    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'subscription_plan' => ['required', 'string'],
        ]);

        $organization->update($request->only('name', 'email', 'phone', 'address', 'subscription_plan'));

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

    public function resetSubscription($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->subscription_ends_at = now()->addDays(14);
        $organization->status = 'active';
        $organization->save();
        
        return redirect()->route('admin.organizations.index')->with('success', 'Subscription reset to 14 days.');
    }
}
