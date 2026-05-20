<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticTest;
use App\Models\Patient;
use Illuminate\Http\Request;

class LabResultController extends Controller
{
    public function index(Request $request)
    {
        $patients = Patient::where('status', 'active')->with('user')->get();
        $selectedPatientId = $request->get('patient_id');

        $labResults = DiagnosticTest::with(['patient.user', 'uploadedBy'])
            ->when($selectedPatientId, function ($query, $patientId) {
                $query->where('patient_id', $patientId);
            })
            ->latest('requested_at')
            ->get();

        return view('assistant.lab-results.index', compact('labResults', 'patients', 'selectedPatientId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'test_name' => 'required|string|max:255',
            'category' => 'required|in:laboratory,imaging,others',
            'results_findings' => 'nullable|string',
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('diagnostic_results', 'public');
        }

        DiagnosticTest::create([
            'patient_id' => $validated['patient_id'],
            'uploaded_by' => auth()->id(),
            'test_name' => $validated['test_name'],
            'category' => $validated['category'],
            'results_findings' => $validated['results_findings'],
            'attachment_path' => $path,
            'status' => 'resulted',
            'requested_at' => now(),
            'resulted_at' => now(),
        ]);

        return redirect()->route('assistant.lab-results.index', ['patient_id' => $validated['patient_id']])
            ->with('success', 'Lab result uploaded successfully!');
    }
}
