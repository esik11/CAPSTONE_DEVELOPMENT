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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            
            // Receiving Provider Info
            $table->string('receiving_provider_name')->nullable();
            $table->string('receiving_specialty')->nullable();
            $table->string('receiving_facility')->nullable();
            $table->string('receiving_contact')->nullable();
            
            // Clinical Details
            $table->text('reason_for_referral');
            $table->text('medical_history_summary')->nullable();
            $table->text('current_medications')->nullable();
            $table->text('supporting_docs')->nullable(); // Lab/Imaging references
            
            // Insurance & Auth
            $table->string('insurance_provider')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('pre_auth_number')->nullable();
            
            // Status & Metadata
            $table->string('status')->default('pending'); // pending, sent, accepted
            $table->timestamp('signed_at')->nullable();
            $table->string('digital_signature_hash')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
