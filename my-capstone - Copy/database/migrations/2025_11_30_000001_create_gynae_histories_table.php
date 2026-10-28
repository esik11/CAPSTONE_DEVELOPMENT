<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gynae_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained()->onDelete('cascade');
            $table->json('contraception')->nullable(); // Store selected contraception methods
            $table->text('contraception_comments')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gynae_histories');
    }
};
