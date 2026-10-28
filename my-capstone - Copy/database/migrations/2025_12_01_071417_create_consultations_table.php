<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            
            // Consultation metadata
            $table->date('consultation_date');
            $table->time('consultation_time');
            $table->enum('status', ['draft', 'in_progress', 'completed', 'cancelled'])->default('draft');
            $table->enum('current_section', ['symptoms', 'examination', 'diagnosis', 'prescribe'])->default('symptoms');
            
            // Symptoms section - Complaint selection
            $table->json('selected_complaints')->nullable(); // Array of selected complaint buttons
            $table->string('visit_type')->nullable(); // e.g., "COVID-19", "General checkup"
            $table->enum('documentation_mode', ['template', 'freetext', 'hybrid'])->default('template');
            
            // Symptoms section - Template responses
            $table->json('template_responses')->nullable(); // Responses to template questions
            
            // Symptoms section - Generated and manual notes
            $table->text('symptom_notes_auto')->nullable(); // Auto-generated from template
            $table->text('symptom_notes_manual')->nullable(); // Free-text entry by doctor
            $table->text('symptom_notes_final')->nullable(); // Combined final notes
            
            // Symptoms section - Additional details
            $table->string('symptom_onset')->nullable(); // e.g., "3 days ago"
            $table->integer('symptom_duration')->nullable();
            $table->string('symptom_duration_unit')->nullable(); // hours, days, weeks, months
            $table->text('aggravating_factors')->nullable();
            $table->text('relieving_factors')->nullable();
            
            // Symptoms section - Previous episodes
            $table->boolean('previous_episodes')->default(false);
            $table->text('previous_episodes_details')->nullable();
            
            // Symptoms section - Review of systems
            $table->json('review_of_systems')->nullable();
            $table->json('associated_symptoms')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('patient_id');
            $table->index('doctor_id');
            $table->index('consultation_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
