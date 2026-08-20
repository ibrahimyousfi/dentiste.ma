<?php

use App\Http\Controllers\Admin\RegistrationRequestController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AiCopilotController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicOwnerDashboardController;
use App\Http\Controllers\DentalChartController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\LabCaseController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PatientAuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\PatientMediaController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecretaryDashboardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TreatmentPlanController;
use App\Http\Controllers\VoiceNoteController;
use App\Http\Controllers\WaitlistController;
use App\Models\Organization;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $plans = SubscriptionPlan::where('is_active', true)->get();
    $clinics = Organization::whereNotNull('name')->limit(15)->get(['name', 'logo']);
    $globalPlatformLogo = Setting::get('platform_logo');
    $globalPlatformName = Setting::get('platform_name', config('app.name'));

    return view('welcome', compact('plans', 'clinics', 'globalPlatformLogo', 'globalPlatformName'));
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
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Organization Management
        Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations.index');
        Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
        Route::post('/organizations', [OrganizationController::class, 'store'])->name('organizations.store');
        Route::get('/organizations/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');
        Route::get('/organizations/{organization}/edit', [OrganizationController::class, 'edit'])->name('organizations.edit');
        Route::put('/organizations/{organization}', [OrganizationController::class, 'update'])->name('organizations.update');
        Route::post('/organizations/{organization}/suspend', [OrganizationController::class, 'suspend'])->name('organizations.suspend');

        // Registration Requests
        Route::get('/registration-requests', [RegistrationRequestController::class, 'index'])->name('registration-requests.index');
        Route::post('/registration-requests/{request}/status', [RegistrationRequestController::class, 'updateStatus'])->name('registration-requests.update-status');
        Route::delete('/registration-requests/{request}', [RegistrationRequestController::class, 'destroy'])->name('registration-requests.destroy');

        Route::resource('/subscription-plans', SubscriptionPlanController::class)->only(['index', 'edit', 'update']);
        Route::get('/subscriptions', [App\Http\Controllers\Admin\SubscriptionController::class, 'index'])->name('subscriptions');
        Route::post('/subscriptions/{subscription}/update-plan', [App\Http\Controllers\Admin\SubscriptionController::class, 'updatePlan'])->name('subscriptions.update-plan');
        Route::post('/subscriptions/{subscription}/extend', [App\Http\Controllers\Admin\SubscriptionController::class, 'extend'])->name('subscriptions.extend');
        Route::post('/subscriptions/{subscription}/suspend', [App\Http\Controllers\Admin\SubscriptionController::class, 'suspend'])->name('subscriptions.suspend');
        Route::post('/subscriptions/requests/{request}/approve', [App\Http\Controllers\Admin\SubscriptionController::class, 'approveRequest'])->name('subscriptions.requests.approve');
        Route::post('/subscriptions/requests/{request}/reject', [App\Http\Controllers\Admin\SubscriptionController::class, 'rejectRequest'])->name('subscriptions.requests.reject');
        Route::get('/revenue', function () {
            return view('admin.revenue');
        })->name('revenue');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // Clinic Owner Dashboard
    Route::get('/clinic/dashboard', [ClinicOwnerDashboardController::class, 'index'])
        ->middleware('can:manage clinic settings')
        ->name('clinic.dashboard');

    // Clinic Owner Staff Management
    Route::middleware('can:manage clinic staff')->prefix('clinic')->group(function () {
        Route::resource('staff', StaffController::class)->except(['show']);

        // Subscription & Billing
        Route::get('/subscription', [SubscriptionController::class, 'index'])->name('clinic.subscription');
        Route::post('/subscription/checkout', [SubscriptionController::class, 'checkout'])->name('clinic.subscription.checkout');
    });

    // Secretary Dashboard
    Route::get('/secretary/dashboard', [SecretaryDashboardController::class, 'index'])
        ->middleware('can:manage appointments')
        ->name('secretary.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/clinic', [ProfileController::class, 'updateClinic'])->name('profile.updateClinic');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/patients/{patient}/notes', [PatientController::class, 'storeNote'])->name('patients.notes.store');
    Route::post('/patients/{patient}/notes/voice', [VoiceNoteController::class, 'transcribe'])->name('patients.notes.voice');
    Route::post('/patients/{patient}/media', [PatientMediaController::class, 'store'])->name('patients.media.store');
    Route::delete('/media/{media}', [PatientMediaController::class, 'destroy'])->name('media.destroy');
    Route::resource('patients', PatientController::class);
    Route::post('patients/{patient}/increment-session', [PatientController::class, 'incrementSession'])->name('patients.increment-session');
    Route::post('patients/{patient}/set-sessions', [PatientController::class, 'setSessions'])->name('patients.set-sessions');
    Route::post('patients/{patient}/recall', [PatientController::class, 'recall'])->name('patients.recall');
    Route::post('waitlist/{waitlist}/notify', [WaitlistController::class, 'notify'])->name('waitlist.notify');
    Route::get('patients/{patient}/dental-chart', [DentalChartController::class, 'show'])->name('patients.dental-chart');
    Route::get('patients/{patient}/dental-chart/print', [DentalChartController::class, 'print'])->name('patients.dental-chart.print');
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
    Route::post('/ai-copilot/chat', [AiCopilotController::class, 'chat'])->name('ai-copilot.chat');
    Route::get('/ai-copilot/status', [AiCopilotController::class, 'status'])->name('ai-copilot.status');

    // Financial Routes
    Route::resource('payments', PaymentController::class)->only(['store', 'index']);

    Route::post('/invoices/{invoice}/pay', [InvoiceController::class, 'pay'])->name('invoices.pay');
    Route::resource('invoices', InvoiceController::class);
});

// ==========================================
// Patient Portal Routes (Password-less)
// ==========================================
Route::prefix('portal')->name('patient.')->group(function () {
    // Guest patient routes
    Route::middleware('guest:patient')->group(function () {
        Route::get('login', [PatientAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [PatientAuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.post');
    });

    // Authenticated patient routes
    Route::middleware('auth:patient')->group(function () {
        Route::post('logout', [PatientAuthController::class, 'logout'])->name('logout');

        Route::get('dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
        Route::get('chart', [PatientDashboardController::class, 'chart'])->name('chart');
        Route::get('payments', [PatientDashboardController::class, 'payments'])->name('payments');
    });
});

// ==========================================
// Kiosk Mode Routes (Waiting Room Tablet)
// ==========================================
Route::prefix('kiosk')->name('kiosk.')->middleware('throttle:60,1')->group(function () {
    Route::get('/', [KioskController::class, 'index'])->name('index');
    Route::post('/identify', [KioskController::class, 'identify'])->name('identify');
    Route::get('/form', [KioskController::class, 'form'])->name('form');
    Route::post('/submit', [KioskController::class, 'submit'])->name('submit');
    Route::get('/done', [KioskController::class, 'done'])->name('done');
});

require __DIR__.'/auth.php';
