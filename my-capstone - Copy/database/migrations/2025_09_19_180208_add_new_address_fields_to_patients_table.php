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
        Schema::table('patients', function (Blueprint $table) {
            $table->string('emergency_region')->nullable()->after('emergency_relationship');
            $table->string('emergency_province')->nullable()->after('emergency_region');
            $table->string('emergency_barangay')->nullable()->after('emergency_province');
            $table->string('other_region')->nullable()->after('other_relationship');
            $table->string('other_province')->nullable()->after('other_region');
            $table->string('other_barangay')->nullable()->after('other_province');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'emergency_region',
                'emergency_province',
                'emergency_barangay',
                'other_region',
                'other_province',
                'other_barangay',
            ]);
        });
    }
};
