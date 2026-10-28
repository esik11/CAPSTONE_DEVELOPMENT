<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class NewAppointmentRequest extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $patientName = $this->appointment->patient->user->name;
        $doctorName = $this->appointment->doctor->name;
        $time = $this->appointment->start_time->format('M d, g:i A');

        return [
            'title' => 'New Appointment Request',
            'message' => "{$patientName} has requested an appointment with Dr. {$doctorName} for {$time}.",
            'appointment_id' => $this->appointment->id,
            'type' => 'new_request',
        ];
    }
}
