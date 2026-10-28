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
        Schema::create('social_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained()->onDelete('cascade');
            $table->string('smoking')->nullable();
            $table->string('alcohol')->nullable();
            $table->string('drug_use')->nullable();
            $table->text('diet_exercise')->nullable();
            $table->text('occupation')->nullable();
            $table->text('living_situation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_histories');
    }
};
