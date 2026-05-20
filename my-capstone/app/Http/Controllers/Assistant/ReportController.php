<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function patientRoster()
    {
        $patients = Patient::orderBy('last_name')->orderBy('first_name')->get();
        
        return view('assistant.reports.patient-roster', compact('patients'));
    }

    public function dailySchedule(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        
        $appointments = Appointment::with('patient')
            ->whereDate('start_time', $date)
            ->orderBy('start_time')
            ->get();
            
        return view('assistant.reports.daily-schedule', compact('appointments', 'date'));
    }
}
