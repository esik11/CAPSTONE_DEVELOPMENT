<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('icd10_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // e.g., J20.9
            $table->string('description'); // e.g., Acute bronchitis, unspecified
            $table->string('category', 50)->nullable(); // e.g., Respiratory, Cardiovascular
            $table->boolean('is_common')->default(false); // Flag for frequently used codes
            $table->timestamps();
            
            // Indexes for fast searching
            $table->index('code');
            $table->index('is_common');
            $table->fullText(['code', 'description']); // For search functionality
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('icd10_codes');
    }
};
