<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Fix: Change JSON columns to TEXT for encrypted fields
     * Reason: Encrypted data is base64 string, not valid JSON
     * MySQL JSON columns have CHECK constraints that reject non-JSON data
     */
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Change encrypted JSON columns to TEXT
            $table->text('selected_complaints')->nullable()->change();
            $table->text('template_responses')->nullable()->change();
            $table->text('review_of_systems')->nullable()->change();
            $table->text('associated_symptoms')->nullable()->change();
            $table->text('cardiovascular_findings')->nullable()->change();
            $table->text('respiratory_findings')->nullable()->change();
            $table->text('abdominal_findings')->nullable()->change();
            $table->text('neurological_findings')->nullable()->change();
            $table->text('musculoskeletal_findings')->nullable()->change();
            $table->text('heent_findings')->nullable()->change();
            $table->text('skin_findings')->nullable()->change();
            $table->text('diagnoses')->nullable()->change();
            $table->text('prescriptions')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Revert back to JSON (only if you remove encryption)
            $table->json('selected_complaints')->nullable()->change();
            $table->json('template_responses')->nullable()->change();
            $table->json('review_of_systems')->nullable()->change();
            $table->json('associated_symptoms')->nullable()->change();
            $table->json('cardiovascular_findings')->nullable()->change();
            $table->json('respiratory_findings')->nullable()->change();
            $table->json('abdominal_findings')->nullable()->change();
            $table->json('neurological_findings')->nullable()->change();
            $table->json('musculoskeletal_findings')->nullable()->change();
            $table->json('heent_findings')->nullable()->change();
            $table->json('skin_findings')->nullable()->change();
            $table->json('diagnoses')->nullable()->change();
            $table->json('prescriptions')->nullable()->change();
        });
    }
};
