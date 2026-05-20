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
        Schema::create('diagnostic_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('consultation_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('test_name');
            $table->enum('category', ['laboratory', 'imaging', 'others'])->default('laboratory');
            $table->string('reference_number')->nullable();
            
            $table->text('request_notes')->nullable();
            $table->text('results_findings')->nullable();
            $table->string('attachment_path')->nullable(); // For PDF or Image
            
            $table->enum('status', ['requested', 'pending', 'resulted', 'cancelled'])->default('requested');
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('resulted_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnostic_tests');
    }
};
