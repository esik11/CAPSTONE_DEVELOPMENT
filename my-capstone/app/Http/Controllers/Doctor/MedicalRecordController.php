<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index(Patient $patient)
    {
        $medicalRecords = $patient->medicalRecords()->with('medicalCondition')->latest()->get();
        return response()->json($medicalRecords);
    }
}
