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
        $status = ucfirst($this->appointment->status);
        $patientName = $this->appointment->patient->user->name ?? 'Patient';
        $doctorName = $this->appointment->doctor->name ?? 'Doctor';
        $appointmentTime = $this->appointment->start_time->format('F j, Y, g:i a');

        $subject = "Appointment {$status}: {$appointmentTime}";
        $greeting = "Hello {$notifiable->name},";

        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line("Your appointment with {$doctorName} for {$patientName} on {$appointmentTime} has been {$status}.")
            ->action('View Appointment', url('/appointments/' . $this->appointment->id))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
