<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gynae_histories', function (Blueprint $table) {
            $table->integer('age_at_menarche')->nullable()->after('contraception_comments');
            $table->date('last_menstrual_period')->nullable()->after('age_at_menarche');
            $table->string('cycle_regularity')->nullable()->after('last_menstrual_period'); // regular, irregular, stopped
            $table->integer('cycle_length_days')->nullable()->after('cycle_regularity');
            $table->json('menstrual_issues')->nullable()->after('cycle_length_days');
            $table->text('menstrual_comments')->nullable()->after('menstrual_issues');
        });
    }

    public function down(): void
    {
        Schema::table('gynae_histories', function (Blueprint $table) {
            $table->dropColumn([
                'age_at_menarche',
                'last_menstrual_period',
                'cycle_regularity',
                'cycle_length_days',
                'menstrual_issues',
                'menstrual_comments',
            ]);
        });
    }
};
