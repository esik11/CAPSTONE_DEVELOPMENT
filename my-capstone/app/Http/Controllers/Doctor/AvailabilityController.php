<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\DoctorAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AvailabilityController extends Controller
{
    /**
     * Display the doctor's availability settings.
     */
    public function index()
    {
        $doctor = Auth::user();
        
        // Group availabilities by day_of_week
        $availabilities = $doctor->availabilities->groupBy('day_of_week');
        
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            0 => 'Sunday',
        ];

        return view('doctor.availability.index', compact('availabilities', 'days'));
    }

    /**
     * Update the doctor's availability settings.
     */
    public function update(Request $request)
    {
        $doctor = Auth::user();
        
        $request->validate([
            'days' => 'sometimes|array',
            'days.*.slots' => 'array',
            'days.*.slots.*.start' => 'required|date_format:H:i',
            'days.*.slots.*.end' => 'required|date_format:H:i|after:days.*.slots.*.start',
        ]);

        DB::transaction(function () use ($doctor, $request) {
            // Remove existing slots to rebuild
            DoctorAvailability::where('doctor_id', $doctor->id)->delete();

            $days = $request->input('days', []);
            foreach ($days as $dayId => $dayData) {
                if (isset($dayData['is_available']) && isset($dayData['slots'])) {
                    foreach ($dayData['slots'] as $slot) {
                        DoctorAvailability::create([
                            'doctor_id' => $doctor->id,
                            'day_of_week' => $dayId,
                            'start_time' => $slot['start'],
                            'end_time' => $slot['end'],
                            'is_available' => true,
                        ]);
                    }
                }
            }
        });

        // Notify all clinic assistants about the availability update
        $assistants = \App\Models\User::where('role', 'assistant')->get();
        if ($assistants->count() > 0) {
            \Illuminate\Support\Facades\Notification::send($assistants, new \App\Notifications\DoctorAvailabilitySet($doctor));
        }

        return redirect()->back()->with('success', 'Your visual clinical schedule has been updated successfully.');
    }
}
