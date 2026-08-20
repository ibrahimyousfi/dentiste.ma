<?php

namespace App\Http\Controllers;

use App\Models\Waitlist;
use App\Models\Patient;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaitlistController extends Controller
{
    /**
     * Notify a waitlist patient that an appointment opened up.
     */
    public function notify(Request $request, Waitlist $waitlist, WhatsAppServiceInterface $whatsappService)
    {
        // Ensure the waitlist belongs to the same organization
        if ($waitlist->organization_id !== Auth::user()->organization_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $patient = $waitlist->patient;
        $orgName = Auth::user()->organization->name ?? 'Our Dental Clinic';

        // Message to send
        $message = "Hello {$patient->first_name},\n\n";
        $message .= "This is {$orgName}. We wanted to let you know that a time slot has just opened up!\n\n";
        $message .= "Since you are on our waitlist, we are offering this to you first. Please contact us as soon as possible if you would like to book it.\n\n";
        $message .= "Thank you!";

        try {
            $organization = auth()->user()->organization;
            if (!$organization->hasFeature('whatsapp_reminders')) {
                return back()->with('error', 'Your current subscription plan does not support WhatsApp notifications. Please upgrade your plan.');
            }

            // Send WhatsApp message
            $whatsappService->sendMessage($patient->phone, $message);
            
            // Mark as notified/completed
            $waitlist->update(['status' => 'notified']);
            
            return response()->json(['success' => true, 'message' => 'Patient notified successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send notification: ' . $e->getMessage()]);
        }
    }
}
