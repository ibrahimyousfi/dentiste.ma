<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $platformName = Setting::get('platform_name', 'Dental SaaS');
        $platformLogo = Setting::get('platform_logo');

        return view('admin.settings', compact('platformName', 'platformLogo'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'platform_name' => 'required|string|max:255',
            'platform_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        Setting::set('platform_name', $request->platform_name);

        if ($request->hasFile('platform_logo')) {
            $logoPath = $request->file('platform_logo')->store('logos', 'public');
            
            // Delete old logo if exists
            $oldLogo = Setting::get('platform_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            Setting::set('platform_logo', $logoPath);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
