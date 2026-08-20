<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DentalChartController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LabCaseController;
use App\Http\Controllers\TreatmentPlanController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $plans = App\Models\SubscriptionPlan::where('is_active', true)->get();
    $clinics = App\Models\Organization::whereNotNull('name')->limit(15)->get(['name', 'logo']);
    return view('welcome', compact('plans', 'clinics'));
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('Super Admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('Secretary')) {
        return redirect()->route('secretary.dashboard');
    } elseif ($user->hasRole('Clinic Owner')) {
        return redirect()->route('clinic.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================================
// Role-Based Dashboards
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    // Super Admin Dashboard & Management
    Route::middleware('can:manage global system')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Organization Management
        Route::get('/organizations', [App\Http\Controllers\OrganizationController::class, 'index'])->name('organizations.index');
        Route::get('/organizations/create', [App\Http\Controllers\OrganizationController::class, 'create'])->name('organizations.create');
        Route::post('/organizations', [App\Http\Controllers\OrganizationController::class, 'store'])->name('organizations.store');
        Route::get('/organizations/{organization}', [App\Http\Controllers\OrganizationController::class, 'show'])->name('organizations.show');
        Route::get('/organizations/{organization}/edit', [App\Http\Controllers\OrganizationController::class, 'edit'])->name('organizations.edit');
        Route::put('/organizations/{organization}', [App\Http\Controllers\OrganizationController::class, 'update'])->name('organizations.update');
        Route::post('/organizations/{organization}/suspend', [App\Http\Controllers\OrganizationController::class, 'suspend'])->name('organizations.suspend');

        Route::get('/subscriptions', [\App\Http\Controllers\Admin\SubscriptionController::class, 'index'])->name('subscriptions');
        Route::post('/subscriptions/{subscription}/update-plan', [\App\Http\Controllers\Admin\SubscriptionController::class, 'updatePlan'])->name('subscriptions.update-plan');
        Route::post('/subscriptions/{subscription}/extend', [\App\Http\Controllers\Admin\SubscriptionController::class, 'extend'])->name('subscriptions.extend');
        Route::post('/subscriptions/{subscription}/suspend', [\App\Http\Controllers\Admin\SubscriptionController::class, 'suspend'])->name('subscriptions.suspend');
        Route::post('/subscriptions/requests/{request}/approve', [\App\Http\Controllers\Admin\SubscriptionController::class, 'approveRequest'])->name('subscriptions.requests.approve');
        Route::post('/subscriptions/requests/{request}/reject', [\App\Http\Controllers\Admin\SubscriptionController::class, 'rejectRequest'])->name('subscriptions.requests.reject');
        Route::get('/revenue', function() { return view('admin.revenue'); })->name('revenue');
        Route::get('/settings', function() { return view('admin.settings'); })->name('settings');
    });

    // Clinic Owner Dashboard
    Route::get('/clinic/dashboard', [App\Http\Controllers\ClinicOwnerDashboardController::class, 'index'])
        ->middleware('can:manage clinic settings')
        ->name('clinic.dashboard');

    // Clinic Owner Staff Management
    Route::middleware('can:manage clinic staff')->prefix('clinic')->group(function () {
        Route::resource('staff', App\Http\Controllers\StaffController::class)->except(['show']);
        
        // Subscription & Billing
        Route::get('/subscription', [App\Http\Controllers\SubscriptionController::class, 'index'])->name('clinic.subscription');
        Route::post('/subscription/checkout', [App\Http\Controllers\SubscriptionController::class, 'checkout'])->name('clinic.subscription.checkout');
    });

    // Secretary Dashboard
    Route::get('/secretary/dashboard', [App\Http\Controllers\SecretaryDashboardController::class, 'index'])
        ->middleware('can:manage appointments')
        ->name('secretary.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/clinic', [ProfileController::class, 'updateClinic'])->name('profile.updateClinic');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/patients/{patient}/notes', [PatientController::class, 'storeNote'])->name('patients.notes.store');
    Route::post('/patients/{patient}/notes/voice', [\App\Http\Controllers\VoiceNoteController::class, 'transcribe'])->name('patients.notes.voice');
    Route::post('/patients/{patient}/media', [App\Http\Controllers\PatientMediaController::class, 'store'])->name('patients.media.store');
    Route::delete('/media/{media}', [App\Http\Controllers\PatientMediaController::class, 'destroy'])->name('media.destroy');
    Route::resource('patients', PatientController::class);
    Route::post('patients/{patient}/increment-session', [PatientController::class, 'incrementSession'])->name('patients.increment-session');
    Route::post('patients/{patient}/set-sessions', [PatientController::class, 'setSessions'])->name('patients.set-sessions');
    Route::post('patients/{patient}/recall', [PatientController::class, 'recall'])->name('patients.recall');
    Route::post('waitlist/{waitlist}/notify', [\App\Http\Controllers\WaitlistController::class, 'notify'])->name('waitlist.notify');
    Route::get('patients/{patient}/dental-chart', [DentalChartController::class, 'show'])->name('patients.dental-chart');
    Route::post('patients/{patient}/dental-chart', [DentalChartController::class, 'store'])->name('patients.dental-chart.store');
    Route::post('patients/{patient}/dental-chart/generate-plan', [DentalChartController::class, 'generatePlan'])->name('patients.dental-chart.generate-plan');
    Route::resource('inventory', InventoryController::class);
    Route::resource('lab-cases', LabCaseController::class);
    Route::patch('treatment-plans/{treatment_plan}/status', [TreatmentPlanController::class, 'updateStatus'])->name('treatment-plans.update-status');
    Route::post('treatment-plans/{treatment_plan}/sessions', [TreatmentPlanController::class, 'storeSession'])->name('treatment-plans.sessions.store');
    Route::resource('treatment-plans', TreatmentPlanController::class);
    Route::resource('prescriptions', PrescriptionController::class);
    
    // UI Routes for Demo
    // Professional Calendar Routes
    Route::resource('appointments', AppointmentController::class)->except(['create', 'edit', 'show']);
    Route::patch('appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.update-status');
    
    // AI Copilot Routes
    Route::post('/ai-copilot/chat', [App\Http\Controllers\AiCopilotController::class, 'chat'])->name('ai-copilot.chat');
    Route::get('/ai-copilot/status', [App\Http\Controllers\AiCopilotController::class, 'status'])->name('ai-copilot.status');
    
    // Financial Routes
    Route::resource('payments', App\Http\Controllers\PaymentController::class)->only(['store', 'index']);
    
    Route::post('/invoices/{invoice}/pay', [App\Http\Controllers\InvoiceController::class, 'pay'])->name('invoices.pay');
    Route::resource('invoices', App\Http\Controllers\InvoiceController::class);
});

// ==========================================
// Patient Portal Routes (Password-less)
// ==========================================
Route::prefix('portal')->name('patient.')->group(function () {
    // Guest patient routes
    Route::middleware('guest:patient')->group(function () {
        Route::get('login', [App\Http\Controllers\PatientAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [App\Http\Controllers\PatientAuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.post');
    });

    // Authenticated patient routes
    Route::middleware('auth:patient')->group(function () {
        Route::post('logout', [App\Http\Controllers\PatientAuthController::class, 'logout'])->name('logout');
        
        Route::get('dashboard', [App\Http\Controllers\PatientDashboardController::class, 'index'])->name('dashboard');
        Route::get('chart', [App\Http\Controllers\PatientDashboardController::class, 'chart'])->name('chart');
        Route::get('payments', [App\Http\Controllers\PatientDashboardController::class, 'payments'])->name('payments');
    });
});

// ==========================================
// Kiosk Mode Routes (Waiting Room Tablet)
// ==========================================
Route::prefix('kiosk')->name('kiosk.')->middleware('throttle:60,1')->group(function () {
    Route::get('/', [App\Http\Controllers\KioskController::class, 'index'])->name('index');
    Route::post('/identify', [App\Http\Controllers\KioskController::class, 'identify'])->name('identify');
    Route::get('/form', [App\Http\Controllers\KioskController::class, 'form'])->name('form');
    Route::post('/submit', [App\Http\Controllers\KioskController::class, 'submit'])->name('submit');
    Route::get('/done', [App\Http\Controllers\KioskController::class, 'done'])->name('done');
});

require __DIR__.'/auth.php';
