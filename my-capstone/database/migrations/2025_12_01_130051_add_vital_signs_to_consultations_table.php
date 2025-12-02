<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Vital Signs
            $table->decimal('temperature', 4, 1)->nullable()->after('associated_symptoms');
            $table->integer('pulse_rate')->nullable();
            $table->string('blood_pressure', 20)->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->integer('spo2')->nullable();
            $table->decimal('weight', 5, 1)->nullable();
            $table->integer('height')->nullable();
            $table->integer('waist_circumference')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn([
                'temperature',
                'pulse_rate',
                'blood_pressure',
                'respiratory_rate',
                'spo2',
                'weight',
                'height',
                'waist_circumference',
            ]);
        });
    }
};
