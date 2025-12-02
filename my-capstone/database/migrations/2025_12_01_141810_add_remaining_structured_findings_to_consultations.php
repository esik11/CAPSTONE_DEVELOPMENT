<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->json('abdominal_findings')->nullable()->after('abdominal_exam');
            $table->json('neurological_findings')->nullable()->after('neurological_exam');
            $table->json('musculoskeletal_findings')->nullable()->after('musculoskeletal_exam');
            $table->json('heent_findings')->nullable()->after('heent_exam');
            $table->json('skin_findings')->nullable()->after('skin_exam');
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn([
                'abdominal_findings',
                'neurological_findings',
                'musculoskeletal_findings',
                'heent_findings',
                'skin_findings'
            ]);
        });
    }
};
