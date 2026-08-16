<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientMediaController extends Controller
{
    public function store(Request $request, \App\Models\Patient $patient)
    {
        $request->validate([
            'media_file' => 'required|file|mimes:jpeg,png,jpg,webp,pdf|max:10240', // 10MB max
            'category' => 'required|string|in:X-Ray,Scan,Intraoral Photo,Document',
            'notes' => 'nullable|string',
            'taken_at' => 'nullable|date',
        ]);

        $file = $request->file('media_file');
        
        // Store the file in public disk, under patient's folder
        $path = $file->store("patients/{$patient->id}/media", 'public');

        $patient->media()->create([
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientMimeType(),
            'category' => $request->category,
            'notes' => $request->notes,
            'taken_at' => $request->taken_at ?? now(),
        ]);

        return back()->with('success', 'Media uploaded successfully.');
    }

    public function destroy(\App\Models\PatientMedia $media)
    {
        // Delete the file from storage
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($media->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return back()->with('success', 'Media deleted successfully.');
    }
}
