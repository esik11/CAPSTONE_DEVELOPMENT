<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('medical_record_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null'); // Doctor/Nurse who recorded
            
            // Vital signs measurements
            $table->decimal('weight', 5, 2)->nullable()->comment('Weight in kg');
            $table->decimal('height', 5, 2)->nullable()->comment('Height in cm');
            $table->decimal('bmi', 4, 2)->nullable()->comment('Body Mass Index');
            $table->string('blood_pressure')->nullable()->comment('e.g., 120/80');
            $table->integer('systolic')->nullable()->comment('Systolic BP');
            $table->integer('diastolic')->nullable()->comment('Diastolic BP');
            $table->decimal('temperature', 4, 1)->nullable()->comment('Temperature in Celsius');
            $table->integer('pulse_rate')->nullable()->comment('Heart rate in bpm');
            $table->integer('respiratory_rate')->nullable()->comment('Breaths per minute');
            $table->integer('oxygen_saturation')->nullable()->comment('SpO2 percentage');
            $table->decimal('blood_glucose', 5, 2)->nullable()->comment('Blood sugar in mmol/L');
            
            // Additional measurements
            $table->decimal('head_circumference', 5, 2)->nullable()->comment('For pediatric patients in cm');
            $table->text('notes')->nullable();
            
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index(['patient_id', 'recorded_at']);
            $table->index('medical_record_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};
