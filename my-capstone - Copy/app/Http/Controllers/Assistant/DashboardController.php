<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get today's appointments
        $todayAppointments = Appointment::whereDate('start_time', Carbon::today())
            ->with(['patient.user', 'doctor'])
            ->orderBy('start_time', 'asc')
            ->get();

        // Get statistics
        $stats = [
            'total_patients' => Patient::where('status', 'active')->count(),
            'today_appointments' => $todayAppointments->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'checked_in_today' => Appointment::whereDate('start_time', Carbon::today())
                ->where('status', 'checked_in')
                ->count(),
        ];

        return view('assistant.dashboard', compact('todayAppointments', 'stats'));
    }
}
