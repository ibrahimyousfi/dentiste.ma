<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Services\WhatsApp\WhatsAppServiceInterface;
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
    protected $description = 'Send automated WhatsApp reminders 24 hours before an appointment.';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppServiceInterface $whatsappService)
    {
        $this->info('Finding appointments for tomorrow...');

        // Find appointments exactly tomorrow that are scheduled and haven't been reminded yet
        $tomorrow = Carbon::tomorrow()->toDateString();
        
        $appointments = Appointment::with(['patient', 'organization'])
            ->whereDate('appointment_date', $tomorrow)
            ->whereIn('status', ['Scheduled', 'scheduled', 'waiting'])
            ->whereNull('reminder_sent_at')
            ->get();

        $count = $appointments->count();
        $this->info("Found {$count} appointments to remind.");

        foreach ($appointments as $appointment) {
            $patient = $appointment->patient;
            $orgName = $appointment->organization->name ?? 'Dental Clinic';
            
            // Format time
            $time = Carbon::parse($appointment->start_time)->format('h:i A');
            
            // Compose the WhatsApp Message
            $message = "Hello {$patient->first_name},\n\n";
            $message .= "This is a friendly reminder from *{$orgName}* about your dental appointment tomorrow at *{$time}*.\n\n";
            $message .= "Please reply to this message to confirm your attendance.\n\n";
            $message .= "We look forward to seeing you!";

            // Send via Service
            $whatsappService->sendMessage($patient->phone, $message);
            
            $this->line("Sent reminder to: {$patient->first_name} {$patient->last_name} (Phone: {$patient->phone})");
            
            // Update the flag
            $appointment->reminder_sent_at = now();
            $appointment->save();
        }

        $this->info('All reminders sent successfully!');
    }
}
