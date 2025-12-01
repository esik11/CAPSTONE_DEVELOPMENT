<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_type_templates', function (Blueprint $table) {
            $table->id();
            $table->string('visit_type_name', 100)->unique();
            $table->json('template_questions'); // Structured questions for this visit type
            $table->json('required_fields')->nullable(); // Fields that must be completed
            $table->timestamps();
            
            // Index for faster lookups
            $table->index('visit_type_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_type_templates');
    }
};
