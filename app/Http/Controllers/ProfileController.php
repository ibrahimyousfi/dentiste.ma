<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->validate([
            'language' => ['required', 'string', 'in:en,fr,ar'],
        ]);

        $request->user()->fill($request->validated());
        $request->user()->language = $request->language;

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the clinic's settings.
     */
    public function updateClinic(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (!$user->hasRole('Clinic Owner') || !$user->organization) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'max:2048'], // max 2MB
            'currency' => ['required', 'string', 'in:USD,EUR,MAD,GBP,CAD,AUD,AED,SAR'],
            'timezone' => ['required', 'string'],
            'date_format' => ['required', 'string', 'in:Y-m-d,d/m/Y,m/d/Y'],
        ]);

        $organization = $user->organization;
        $organization->name = $request->name;
        $organization->phone = $request->phone;
        $organization->address = $request->address;
        $organization->currency = $request->currency;
        $organization->timezone = $request->timezone;
        $organization->date_format = $request->date_format;

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('clinic_logos', 'public');
            $organization->logo = $path;
        }

        $organization->save();

        return Redirect::route('profile.edit')->with('status', 'clinic-updated');
    }
}
