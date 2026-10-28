<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->json('cardiovascular_findings')->nullable()->after('cardiovascular_exam');
            $table->json('respiratory_findings')->nullable()->after('respiratory_exam');
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn(['cardiovascular_findings', 'respiratory_findings']);
        });
    }
};
