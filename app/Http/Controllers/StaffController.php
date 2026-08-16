<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    /**
     * Display a listing of the staff members in the current clinic.
     */
    public function index()
    {
        $organizationId = Auth::user()->organization_id;
        
        // Fetch all users belonging to this clinic, except Super Admins
        $staffMembers = User::where('organization_id', $organizationId)
            ->whereDoesntHave('roles', function($q) {
                $q->where('name', 'Super Admin');
            })
            ->get();

        return view('clinic-owner.staff.index', compact('staffMembers'));
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create()
    {
        return view('clinic-owner.staff.create');
    }

    /**
     * Store a newly created staff member in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:Clinic Owner,Secretary,Dentist,Assistant'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organization_id' => Auth::user()->organization_id, // Securely assign to same clinic
        ]);

        // Assign the selected role using Spatie Permission
        $user->assignRole($request->role);

        return redirect()->route('staff.index')->with('success', 'Staff member added successfully.');
    }
    /**
     * Show the form for editing the specified staff member.
     */
    public function edit(User $staff)
    {
        // Ensure they belong to the same clinic
        if ($staff->organization_id !== Auth::user()->organization_id) {
            abort(403);
        }

        return view('clinic-owner.staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff member in storage.
     */
    public function update(Request $request, User $staff)
    {
        // Ensure they belong to the same clinic
        if ($staff->organization_id !== Auth::user()->organization_id) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$staff->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:Clinic Owner,Secretary,Dentist,Assistant'],
        ]);

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $staff->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Sync the role
        $staff->syncRoles([$request->role]);

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully.');
    }

    /**
     * Remove the specified staff member from storage.
     */
    public function destroy(User $staff)
    {
        // Ensure they belong to the same clinic
        if ($staff->organization_id !== Auth::user()->organization_id) {
            abort(403);
        }

        // Prevent self-deletion
        if ($staff->id === Auth::id()) {
            return redirect()->route('staff.index')->with('error', 'You cannot delete yourself.');
        }

        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff member removed successfully.');
    }
}
