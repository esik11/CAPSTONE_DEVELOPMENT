<?php

namespace App\Livewire\Doctor\Consultation;

use App\Models\Consultation;
use App\Models\Referral;
use Livewire\Component;

class ReferralLetterModal extends Component
{
    public $show = false;
    public $consultation;
    public $patient;
    
    // Form fields
    public $receiving_provider_name;
    public $receiving_specialty;
    public $receiving_facility;
    public $receiving_contact;
    public $reason_for_referral;
    public $medical_history_summary;
    public $current_medications;
    public $insurance_provider;
    public $policy_number;
    public $pre_auth_number;
    public $is_digitally_signed = false;

    protected $listeners = ['open-referral-modal' => 'open'];

    public function open($consultationId)
    {
        $this->consultation = Consultation::with(['patient', 'doctor'])->find($consultationId);
        $this->patient = $this->consultation->patient;
        
        // Auto-fill existing referral if any
        $existing = Referral::where('consultation_id', $consultationId)->first();
        if ($existing) {
            $this->receiving_provider_name = $existing->receiving_provider_name;
            $this->receiving_specialty = $existing->receiving_specialty;
            $this->receiving_facility = $existing->receiving_facility;
            $this->receiving_contact = $existing->receiving_contact;
            $this->reason_for_referral = $existing->reason_for_referral;
            $this->medical_history_summary = $existing->medical_history_summary;
            $this->current_medications = $existing->current_medications;
            $this->insurance_provider = $existing->insurance_provider;
            $this->policy_number = $existing->policy_number;
            $this->pre_auth_number = $existing->pre_auth_number;
            $this->is_digitally_signed = !is_null($existing->signed_at);
        } else {
            // New referral - Auto-fill defaults
            $this->reason_for_referral = "Referral for " . ($this->consultation->diagnoses[0]['description'] ?? 'further evaluation');
            $this->medical_history_summary = $this->consultation->symptom_notes_final;
            
            // Format medications for the letter
            $meds = [];
            foreach (($this->consultation->prescriptions ?? []) as $p) {
                $meds[] = $p['medicine_name'] . " (" . $p['dosage'] . ")";
            }
            $this->current_medications = implode("\n", $meds);
        }
        
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
        $this->reset(['receiving_provider_name', 'receiving_specialty', 'receiving_facility', 'receiving_contact', 'reason_for_referral', 'is_digitally_signed']);
    }

    public function save()
    {
        $this->validate([
            'receiving_provider_name' => 'required|string|max:255',
            'reason_for_referral' => 'required|string',
        ]);

        Referral::updateOrCreate(
            ['consultation_id' => $this->consultation->id],
            [
                'patient_id' => $this->patient->id,
                'doctor_id' => auth()->id(),
                'receiving_provider_name' => $this->receiving_provider_name,
                'receiving_specialty' => $this->receiving_specialty,
                'receiving_facility' => $this->receiving_facility,
                'receiving_contact' => $this->receiving_contact,
                'reason_for_referral' => $this->reason_for_referral,
                'medical_history_summary' => $this->medical_history_summary,
                'current_medications' => $this->current_medications,
                'insurance_provider' => $this->insurance_provider,
                'policy_number' => $this->policy_number,
                'pre_auth_number' => $this->pre_auth_number,
                'status' => 'pending',
                'signed_at' => $this->is_digitally_signed ? now() : null,
                'digital_signature_hash' => $this->is_digitally_signed ? md5(auth()->id() . now()) : null,
            ]
        );

        $this->dispatch('show-toast', message: 'Referral letter saved successfully!', type: 'success');
        $this->close();
    }

    public function render()
    {
        return view('livewire.doctor.consultation.referral-letter-modal');
    }
}
