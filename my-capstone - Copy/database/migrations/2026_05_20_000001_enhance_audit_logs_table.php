<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            // Enhanced security fields
            $table->string('session_id')->nullable()->after('user_agent');
            $table->string('device_fingerprint')->nullable()->after('session_id');
            $table->string('location')->nullable()->after('device_fingerprint'); // Geolocation
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical'])->default('low')->after('location');
            $table->boolean('is_anomaly')->default(false)->after('risk_level');
            $table->text('anomaly_reason')->nullable()->after('is_anomaly');
            
            // PHI-specific tracking
            $table->boolean('involves_phi')->default(false)->after('anomaly_reason');
            $table->json('phi_fields_accessed')->nullable()->after('involves_phi'); // Which PHI fields were accessed
            $table->string('access_reason')->nullable()->after('phi_fields_accessed'); // Reason for access
            
            // Compliance fields
            $table->string('request_method')->nullable()->after('access_reason'); // GET, POST, etc.
            $table->text('request_url')->nullable()->after('request_method');
            $table->string('response_status')->nullable()->after('request_url');
            $table->unsignedInteger('duration_ms')->nullable()->after('response_status'); // Request duration
            
            // Tamper detection
            $table->string('hash')->nullable()->after('duration_ms'); // SHA-256 hash of log entry
            $table->unsignedBigInteger('previous_log_id')->nullable()->after('hash');
            
            // Retention and archival
            $table->timestamp('archived_at')->nullable()->after('updated_at');
            $table->boolean('is_archived')->default(false)->after('archived_at');
            
            // Add indexes for performance
            $table->index('session_id');
            $table->index('risk_level');
            $table->index('is_anomaly');
            $table->index('involves_phi');
            $table->index('archived_at');
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn([
                'session_id',
                'device_fingerprint',
                'location',
                'risk_level',
                'is_anomaly',
                'anomaly_reason',
                'involves_phi',
                'phi_fields_accessed',
                'access_reason',
                'request_method',
                'request_url',
                'response_status',
                'duration_ms',
                'hash',
                'previous_log_id',
                'archived_at',
                'is_archived'
            ]);
        });
    }
};
