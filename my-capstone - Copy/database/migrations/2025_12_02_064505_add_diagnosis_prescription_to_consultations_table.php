<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Diagnoses - stores array of diagnosis objects
            $table->json('diagnoses')->nullable()->after('examination_notes');
            
            // Prescriptions - stores array of prescription objects
            $table->json('prescriptions')->nullable()->after('diagnoses');
            
            // Diagnosis notes - additional clinical notes
            $table->text('diagnosis_notes')->nullable()->after('prescriptions');
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn(['diagnoses', 'prescriptions', 'diagnosis_notes']);
        });
    }
};
