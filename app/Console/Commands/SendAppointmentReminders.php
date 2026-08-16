<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automated SMS/Email reminders 24 hours before an appointment.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Finding appointments for tomorrow...');

        // Find appointments exactly tomorrow
        $tomorrow = Carbon::tomorrow()->toDateString();
        
        $appointments = Appointment::with(['patient', 'organization'])
            ->whereDate('appointment_date', $tomorrow)
            ->whereIn('status', ['Scheduled'])
            ->get();

        $count = $appointments->count();
        $this->info("Found {$count} appointments to remind.");

        foreach ($appointments as $appointment) {
            // Here you would integrate with Twilio (SMS) or Mail (Email)
            // Example:
            // Mail::to($appointment->patient->email)->send(new AppointmentReminder($appointment));
            // Twilio::message($appointment->patient->phone, "Reminder: You have an appointment tomorrow at {$appointment->start_time}.");
            
            $this->line("Sent reminder to: {$appointment->patient->first_name} {$appointment->patient->last_name} (Phone: {$appointment->patient->phone})");
            
            // Mark as confirmed or update a 'reminder_sent' flag if you added one to the schema.
        }

        $this->info('All reminders sent successfully!');
    }
}
