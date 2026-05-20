<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class DoctorAppointmentUpdated extends Notification
{
    use Queueable;

    public $appointment;
    public $action; // 'approved', 'rescheduled', 'cancelled'

    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment, $action)
    {
        $this->appointment = $appointment;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Broadcast channel can be added if needed
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $actionText = '';
        $message = '';
        $patientName = $this->appointment->patient->user->name ?? 'Unknown Patient';
        $time = $this->appointment->start_time ? $this->appointment->start_time->format('h:i A') : '';
        $date = $this->appointment->start_time ? $this->appointment->start_time->format('M d, Y') : '';

        switch ($this->action) {
            case 'approved':
                $actionText = 'Appointment Approved';
                $message = "Assistant approved appointment for {$patientName} on {$date} at {$time}.";
                break;
            case 'rescheduled':
                $actionText = 'Appointment Rescheduled';
                $message = "Assistant rescheduled appointment for {$patientName} to {$date} at {$time}.";
                break;
            case 'cancelled':
                $actionText = 'Appointment Cancelled';
                $message = "Assistant cancelled appointment for {$patientName}.";
                break;
            default:
                $actionText = 'Appointment Updated';
                $message = "Appointment for {$patientName} was updated.";
                break;
        }

        return [
            'title' => $actionText,
            'message' => $message,
            'appointment_id' => $this->appointment->id,
            'action' => $this->action,
            'type' => 'appointment_update'
        ];
    }
}
