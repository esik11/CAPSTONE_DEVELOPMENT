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
            $table->dropColumn([
                'emergency_address',
                'emergency_apt_num',
                'emergency_state',
                'other_address',
                'other_apt_num',
                'other_state',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('emergency_address')->nullable()->after('emergency_relationship');
            $table->string('emergency_apt_num')->nullable()->after('emergency_address');
            $table->string('emergency_state')->nullable()->after('emergency_city');
            $table->string('other_address')->nullable()->after('other_relationship');
            $table->string('other_apt_num')->nullable()->after('other_address');
            $table->string('other_state')->nullable()->after('other_city');
        });
    }
};
