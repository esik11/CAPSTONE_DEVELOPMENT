<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticTest;
use Illuminate\Http\Request;

class LabResultController extends Controller
{
    public function index()
    {
        $patient = auth()->user()->patient;

        $labResults = DiagnosticTest::where('patient_id', $patient->id)
            ->latest('requested_at')
            ->get();

        return view('patient.lab-results.index', compact('labResults'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'test_name' => 'required|string|max:255',
            'category' => 'required|in:laboratory,imaging,others',
            'results_findings' => 'nullable|string',
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $patient = auth()->user()->patient;

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('diagnostic_results', 'public');
        }

        DiagnosticTest::create([
            'patient_id' => $patient->id,
            'uploaded_by' => auth()->id(),
            'test_name' => $validated['test_name'],
            'category' => $validated['category'],
            'results_findings' => $validated['results_findings'],
            'attachment_path' => $path,
            'status' => 'resulted',
            'requested_at' => now(),
            'resulted_at' => now(),
        ]);

        return redirect()->route('patient.lab-results.index')
            ->with('success', 'Lab result uploaded successfully!');
    }
}
