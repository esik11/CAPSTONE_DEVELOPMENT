<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class DoctorAvailabilitySet extends Notification
{
    use Queueable;

    public $doctor;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $doctor)
    {
        $this->doctor = $doctor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Broadcast can be added later if needed
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Doctor Availability Updated',
            'message' => "Dr. {$this->doctor->name} has updated their schedule/availability.",
            'doctor_id' => $this->doctor->id,
            'type' => 'availability_update'
        ];
    }
}
