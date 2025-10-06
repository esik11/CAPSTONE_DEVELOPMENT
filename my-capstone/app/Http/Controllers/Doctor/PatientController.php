<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function showDetails(Patient $patient)
    {
        return response()->json($patient->load('user'));
    }
}
