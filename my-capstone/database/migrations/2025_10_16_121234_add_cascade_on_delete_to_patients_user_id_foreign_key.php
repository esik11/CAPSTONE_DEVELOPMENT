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
            // Drop the existing foreign key constraint first
            $table->dropForeign(['user_id']);
            // Then drop the column
            $table->dropColumn('user_id');
        });

        Schema::table('patients', function (Blueprint $table) {
            // Re-add the user_id column with onDelete('cascade')
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Drop the cascaded user_id column
            $table->dropColumn('user_id');
        });

        Schema::table('patients', function (Blueprint $table) {
            // Re-add the original user_id column with onDelete('set null')
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        });
    }
};
