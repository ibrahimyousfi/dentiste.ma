<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClinicRegistrationRequest;
use Illuminate\Http\Request;

class RegistrationRequestController extends Controller
{
    public function index()
    {
        $requests = ClinicRegistrationRequest::latest()->paginate(20);
        return view('admin.registration_requests.index', compact('requests'));
    }

    public function updateStatus(Request $request, $id)
    {
        $registrationRequest = ClinicRegistrationRequest::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,contacted,completed,rejected'
        ]);

        $registrationRequest->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Request status updated successfully.');
    }

    public function destroy($id)
    {
        $registrationRequest = ClinicRegistrationRequest::findOrFail($id);
        $registrationRequest->delete();

        return redirect()->back()->with('success', 'Request deleted successfully.');
    }
}
