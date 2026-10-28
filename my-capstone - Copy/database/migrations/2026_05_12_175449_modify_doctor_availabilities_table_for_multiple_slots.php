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
        Schema::table('doctor_availabilities', function (Blueprint $table) {
            // Drop foreign key first if it's tied to this index
            $table->dropForeign(['doctor_id']);
            
            // Drop the unique constraint
            $table->dropUnique(['doctor_id', 'day_of_week']);
            
            // Re-add foreign key (Laravel will create a regular index for it)
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_availabilities', function (Blueprint $table) {
            $table->unique(['doctor_id', 'day_of_week']);
        });
    }
};
