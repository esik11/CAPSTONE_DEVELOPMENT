<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\DiagnosticTest;
use App\Models\Patient;
use Livewire\Component;
use Livewire\WithFileUploads;

class LabUploadModal extends Component
{
    use WithFileUploads;

    public $show = false;
    public $patientId;
    public $consultationId;
    
    // Form fields
    public $test_name = '';
    public $category = 'laboratory';
    public $results_findings = '';
    public $attachment; // File upload
    
    protected $listeners = ['open-lab-upload-modal' => 'open'];

    public function open($patientId, $consultationId = null)
    {
        $this->patientId = $patientId;
        $this->consultationId = $consultationId;
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
        $this->reset(['test_name', 'results_findings', 'attachment', 'category']);
    }

    public function save()
    {
        $this->validate([
            'test_name' => 'required|string|max:255',
            'category' => 'required|in:laboratory,imaging,others',
            'results_findings' => 'nullable|string',
            'attachment' => 'nullable|image|max:10240', // 10MB max
        ]);

        $path = null;
        if ($this->attachment) {
            $path = $this->attachment->store('diagnostic_results', 'public');
        }

        DiagnosticTest::create([
            'patient_id' => $this->patientId,
            'doctor_id' => auth()->id(),
            'consultation_id' => $this->consultationId,
            'test_name' => $this->test_name,
            'category' => $this->category,
            'results_findings' => $this->results_findings,
            'attachment_path' => $path,
            'status' => 'resulted',
            'requested_at' => now(),
            'resulted_at' => now(),
        ]);

        $this->dispatch('lab-added');
        $this->dispatch('show-toast', message: 'Lab result uploaded successfully!', type: 'success');
        $this->close();
    }

    public function render()
    {
        return view('livewire.doctor.patient.lab-upload-modal');
    }
}
