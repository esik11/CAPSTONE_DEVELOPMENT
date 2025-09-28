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
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('appointment_mode', ['online', 'walk-in', 'follow-up'])->default('online')->after('reason');
            $table->enum('urgency_priority', ['routine', 'urgent', 'emergency'])->default('routine')->after('appointment_mode');
            $table->string('file_path')->nullable()->after('urgency_priority');
            $table->boolean('consent')->default(false)->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['appointment_mode', 'urgency_priority', 'file_path', 'consent']);
        });
    }
};
