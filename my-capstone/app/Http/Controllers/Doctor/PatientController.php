<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Quick search patients for header search bar
     */
    public function quickSearch(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json(['patients' => []]);
        }

        $patients = Patient::with('user')
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                    ->orWhere('last_name', 'like', "%{$query}%")
                    ->orWhere('phone_number', 'like', "%{$query}%")
                    ->orWhere('patient_id', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(function ($patient) {
                return [
                    'id' => $patient->id,
                    'name' => $patient->first_name.' '.$patient->last_name,
                    'patient_id' => $patient->patient_id,
                    'phone' => $patient->phone_number,
                    'age' => $patient->age,
                    'gender' => $patient->gender,
                ];
            });

        return response()->json(['patients' => $patients]);
    }

    public function showDetails(Patient $patient)
    {
        return response()->json($patient->load('user'));
    }
}
