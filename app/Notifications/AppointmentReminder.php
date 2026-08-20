<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $time = Carbon::parse($this->appointment->start_time)->format('h:i A');
        $date = Carbon::parse($this->appointment->appointment_date)->format('l, F j, Y');
        $orgName = $this->appointment->organization->name ?? config('app.name');

        return (new MailMessage)
                    ->subject("Appointment Reminder - {$orgName}")
                    ->greeting("Hello {$notifiable->first_name},")
                    ->line("This is a friendly reminder about your upcoming dental appointment at {$orgName}.")
                    ->line("**Date:** {$date}")
                    ->line("**Time:** {$time}")
                    ->line("**Doctor:** Dr. {$this->appointment->dentist->name}")
                    ->action('Confirm Appointment', url('/')) // In the future, this can link to a patient portal
                    ->line('If you need to reschedule or cancel, please contact us as soon as possible.')
                    ->line('We look forward to seeing you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'message' => 'Reminder sent for appointment on ' . $this->appointment->appointment_date,
        ];
    }
}
