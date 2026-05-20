<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class AppointmentStatusUpdated extends Notification
{
    use Queueable;

    protected $appointment;
    protected $action;

    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment, string $action = null)
    {
        $this->appointment = $appointment;
        $this->action = $action; // e.g. 'rescheduled', 'cancelled', 'confirmed'
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $doctorName = $this->appointment->doctor->name ?? 'Doctor';
        $newTime = $this->appointment->start_time->format('F j, Y \a\t g:i A');

        if ($this->action === 'rescheduled') {
            return (new MailMessage)
                ->subject("Appointment Rescheduled: {$newTime}")
                ->greeting("Hello {$notifiable->name},")
                ->line("Your appointment with Dr. {$doctorName} has been rescheduled.")
                ->line("**New Schedule:** {$newTime}")
                ->action('View Appointment', url('/patient/appointments'))
                ->line('Thank you for choosing Salamat Doc!');
        }

        $status = ucfirst($this->action ?? $this->appointment->status);

        return (new MailMessage)
            ->subject("Appointment {$status}: {$newTime}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your appointment with Dr. {$doctorName} on {$newTime} has been updated to {$status}.")
            ->action('View Appointment', url('/patient/appointments'))
            ->line('Thank you for choosing Salamat Doc!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $doctorName = $this->appointment->doctor->name ?? 'Doctor';
        $newTime = $this->appointment->start_time->format('M j, Y \a\t g:i A');

        if ($this->action === 'rescheduled') {
            return [
                'title' => 'Appointment Rescheduled',
                'message' => "Your appointment with Dr. {$doctorName} has been rescheduled to {$newTime}.",
                'appointment_id' => $this->appointment->id,
                'status' => $this->appointment->status,
            ];
        }

        $status = ucfirst($this->action ?? $this->appointment->status);

        return [
            'title' => 'Appointment Status Updated',
            'message' => "Your appointment with Dr. {$doctorName} is now {$status}.",
            'appointment_id' => $this->appointment->id,
            'status' => $this->appointment->status,
        ];
    }
}
