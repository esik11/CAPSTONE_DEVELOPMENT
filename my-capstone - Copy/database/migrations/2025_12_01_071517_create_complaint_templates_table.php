<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_templates', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_name', 100);
            $table->enum('category', ['adult', 'pediatric', 'both'])->default('both');
            $table->json('template_questions'); // Structured questions for this complaint
            $table->text('output_template'); // Template for generating clinical notes
            $table->json('common_symptoms')->nullable(); // Associated symptoms to check
            $table->timestamps();
            
            // Unique constraint to prevent duplicate complaints per category
            $table->unique(['complaint_name', 'category']);
            
            // Index for faster lookups
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_templates');
    }
};
