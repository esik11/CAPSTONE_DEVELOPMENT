<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Plan & Notes fields
            $table->text('treatment_plan')->nullable()->after('diagnosis_notes');
            $table->text('patient_education')->nullable()->after('treatment_plan');
            $table->text('followup_instructions')->nullable()->after('patient_education');
            $table->text('doctor_notes')->nullable()->after('followup_instructions');
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn(['treatment_plan', 'patient_education', 'followup_instructions', 'doctor_notes']);
        });
    }
};
