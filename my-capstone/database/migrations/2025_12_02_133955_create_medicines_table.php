<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Amoxicillin"
            $table->string('strength')->nullable(); // e.g., "500mg"
            $table->string('form'); // e.g., "Tablet", "Capsule", "Syrup"
            $table->string('generic_name')->nullable(); // Generic name if branded
            $table->text('description')->nullable();
            $table->boolean('is_common')->default(false); // For quick access
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
