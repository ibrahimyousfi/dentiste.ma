<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\InventoryItem;
use App\Models\LabCase;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\TreatmentPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AiCopilotController extends Controller
{
    /**
     * Build a rich clinic context snapshot to inject into the AI's system prompt.
     */
    private function buildClinicContext(): string
    {
        $org = Auth::user()->organization;

        $totalPatients = Patient::count();
        $todayAppts = Appointment::whereDate('appointment_date', today())->count();
        $pendingAppts = Appointment::where('status', 'waiting')->count();

        $monthlyRevenue = Payment::where('organization_id', $org->id)
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        $totalRevenue = Payment::where('organization_id', $org->id)->sum('amount');

        $activePlans = TreatmentPlan::where('status', 'accepted')->count();
        $proposedPlans = TreatmentPlan::where('status', 'proposed')->count();

        $lowStockItems = InventoryItem::where('quantity', '<=', 5)->count();

        $pendingLabCases = LabCase::where('status', 'sent')->count();

        $subscriptionPlan = $org->subscription_plan ?? 'Basic';

        return <<<CONTEXT
You are "Dental Copilot", an intelligent AI assistant embedded inside a dental clinic management system (SaaS) called Dentiste.ma.
You assist clinic owners and dentists in Morocco and worldwide.

IMPORTANT RULES:
- Always respond in the SAME language the user writes in (Arabic → Arabic, French → French, English → English).
- Be concise, professional, and genuinely helpful.
- You have access to real-time clinic data. Use it to answer questions accurately.
- When suggesting navigation or settings, mention the section name clearly (e.g., "Go to Profile & Settings → Clinic Details").
- Never reveal that you are built on any specific AI model.
- If asked about the subscription plan, explain what features are available based on the current plan.
- When answering about financials, format numbers with commas and the currency.

CURRENT CLINIC DATA (Live):
- Clinic Name: {$org->name}
- Subscription Plan: {$subscriptionPlan}
- Total Patients Registered: {$totalPatients}
- Today's Appointments: {$todayAppts}
- Pending (Waiting) Appointments: {$pendingAppts}
- Monthly Revenue (this month): {$monthlyRevenue} MAD
- Total Revenue (all time): {$totalRevenue} MAD
- Active Treatment Plans: {$activePlans}
- Proposed (awaiting approval) Plans: {$proposedPlans}
- Low Stock Inventory Items: {$lowStockItems}
- Pending Lab Cases: {$pendingLabCases}

AVAILABLE SECTIONS IN THE SYSTEM:
- Dashboard: Overview and analytics
- Patients: Patient list, profiles, dental charts
- Appointments: Calendar with scheduling
- Treatment Plans: Planning and tracking treatments
- Prescriptions: Digital prescriptions
- Lab Cases: Laboratory orders
- Invoices: Billing and payments
- Inventory: Stock management
- Staff Management: Clinic team (Clinic Owner only)
- Profile & Settings: Currency, language, clinic details, security
- Subscription & Billing: Plan management (Clinic Owner only)
CONTEXT;
    }

    /**
     * Handle an AI Copilot chat message.
     */
    public function chat(Request $request)
    {
        $org = Auth::user()->organization;
        $plan = $org->subscription_plan ?? 'Basic';

        // Feature gating: only Pro and Premium plans get the AI Copilot
        if (! in_array($plan, ['Pro', 'Premium'])) {
            return response()->json([
                'success' => false,
                'locked' => true,
                'message' => 'The AI Copilot is available on the **Pro** and **Premium** plans. Upgrade your subscription to unlock it.',
            ], 403);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array',
            'history.*.role' => 'required|in:user,assistant',
            'history.*.content' => 'required|string',
        ]);

        $apiKey = env('OPENAI_API_KEY');

        if (! $apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'AI service is not configured. Please add your OPENAI_API_KEY in the .env file.',
            ], 500);
        }

        $systemPrompt = $this->buildClinicContext();

        // Build conversation history for multi-turn chat
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        // Append previous turns (max 10 to limit tokens)
        foreach (array_slice($request->history ?? [], -10) as $turn) {
            $messages[] = ['role' => $turn['role'], 'content' => $turn['content']];
        }

        // Append the new user message
        $messages[] = ['role' => 'user', 'content' => $request->message];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => $messages,
            'temperature' => 0.5,
            'max_tokens' => 600,
        ]);

        if (! $response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'AI service is temporarily unavailable. Please try again.',
            ], 500);
        }

        $reply = $response->json('choices.0.message.content') ?? 'Sorry, I could not generate a response.';

        return response()->json([
            'success' => true,
            'reply' => trim($reply),
        ]);
    }

    /**
     * Return the copilot status for the current organization.
     */
    public function status()
    {
        $org = Auth::user()->organization;
        $plan = $org->subscription_plan ?? 'Basic';
        $isUnlocked = in_array($plan, ['Pro', 'Premium']);

        return response()->json([
            'unlocked' => $isUnlocked,
            'plan' => $plan,
        ]);
    }
}
