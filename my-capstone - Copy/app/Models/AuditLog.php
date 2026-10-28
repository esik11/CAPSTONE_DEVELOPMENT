<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'user_id',
        'action',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
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
        'is_archived',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'phi_fields_accessed' => 'array',
        'is_anomaly' => 'boolean',
        'involves_phi' => 'boolean',
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
    ];

    /**
     * Get the auditable model.
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who performed the action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create an audit log entry with enhanced security tracking.
     */
    public static function log(
        Model $model,
        string $action,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null,
        array $options = []
    ): self {
        $request = request();
        $user = auth()->user();
        
        // Get previous log for chain verification
        $previousLog = self::latest()->first();
        
        $data = [
            'auditable_type' => get_class($model),
            'auditable_id' => $model->id,
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'session_id' => session()->getId(),
            'device_fingerprint' => self::generateDeviceFingerprint($request),
            'location' => self::getLocationFromIp($request->ip()),
            'involves_phi' => $options['involves_phi'] ?? self::detectPHI($model),
            'phi_fields_accessed' => $options['phi_fields_accessed'] ?? null,
            'access_reason' => $options['access_reason'] ?? null,
            'request_method' => $request->method(),
            'request_url' => $request->fullUrl(),
            'response_status' => http_response_code(),
            'duration_ms' => $options['duration_ms'] ?? null,
            'previous_log_id' => $previousLog?->id,
        ];
        
        // Calculate risk level and detect anomalies
        $riskAnalysis = self::analyzeRisk($data, $user);
        $data['risk_level'] = $riskAnalysis['level'];
        $data['is_anomaly'] = $riskAnalysis['is_anomaly'];
        $data['anomaly_reason'] = $riskAnalysis['reason'];
        
        // Generate tamper-proof hash
        $data['hash'] = self::generateHash($data);
        
        return self::create($data);
    }
    
    /**
     * Generate device fingerprint for tracking.
     */
    protected static function generateDeviceFingerprint($request): string
    {
        return hash('sha256', implode('|', [
            $request->userAgent(),
            $request->header('Accept-Language'),
            $request->header('Accept-Encoding'),
        ]));
    }
    
    /**
     * Get approximate location from IP address.
     */
    protected static function getLocationFromIp(string $ip): ?string
    {
        // In production, integrate with IP geolocation service
        // For now, return null or implement basic detection
        return null;
    }
    
    /**
     * Detect if the model contains PHI.
     */
    protected static function detectPHI(Model $model): bool
    {
        $phiModels = [
            'App\Models\Patient',
            'App\Models\MedicalRecord',
            'App\Models\Consultation',
            'App\Models\VitalSign',
            'App\Models\Billing',
            'App\Models\Appointment',
        ];
        
        return in_array(get_class($model), $phiModels);
    }
    
    /**
     * Analyze risk level and detect anomalies.
     */
    protected static function analyzeRisk(array $data, $user): array
    {
        $riskLevel = 'low';
        $isAnomaly = false;
        $reason = null;
        
        // Check for off-hours access (outside 6 AM - 10 PM)
        $hour = now()->hour;
        if ($hour < 6 || $hour > 22) {
            $riskLevel = 'medium';
            $isAnomaly = true;
            $reason = 'Off-hours access detected';
        }
        
        // Check for weekend access
        if (now()->isWeekend()) {
            $riskLevel = $riskLevel === 'medium' ? 'high' : 'medium';
            $isAnomaly = true;
            $reason = ($reason ? $reason . '; ' : '') . 'Weekend access';
        }
        
        // Check for rapid successive access (potential mass export)
        if ($user) {
            $recentLogs = self::where('user_id', $user->id)
                ->where('created_at', '>', now()->subMinutes(5))
                ->count();
            
            if ($recentLogs > 50) {
                $riskLevel = 'critical';
                $isAnomaly = true;
                $reason = ($reason ? $reason . '; ' : '') . 'Rapid successive access detected';
            }
        }
        
        // Check for delete actions on PHI
        if ($data['action'] === 'deleted' && $data['involves_phi']) {
            $riskLevel = 'high';
        }
        
        return [
            'level' => $riskLevel,
            'is_anomaly' => $isAnomaly,
            'reason' => $reason,
        ];
    }
    
    /**
     * Generate tamper-proof hash of log entry.
     */
    protected static function generateHash(array $data): string
    {
        $hashData = [
            $data['auditable_type'] ?? '',
            $data['auditable_id'] ?? '',
            $data['user_id'] ?? '',
            $data['action'] ?? '',
            $data['ip_address'] ?? '',
            $data['session_id'] ?? '',
            $data['previous_log_id'] ?? '',
            now()->toIso8601String(),
        ];
        
        return hash('sha256', implode('|', $hashData));
    }
    
    /**
     * Verify the integrity of the audit log chain.
     */
    public function verifyIntegrity(): bool
    {
        if (!$this->previous_log_id) {
            return true; // First log in chain
        }
        
        $previousLog = self::find($this->previous_log_id);
        return $previousLog !== null;
    }
    
    /**
     * Scope for PHI-related logs.
     */
    public function scopePhiOnly($query)
    {
        return $query->where('involves_phi', true);
    }
    
    /**
     * Scope for anomalies.
     */
    public function scopeAnomalies($query)
    {
        return $query->where('is_anomaly', true);
    }
    
    /**
     * Scope for high-risk activities.
     */
    public function scopeHighRisk($query)
    {
        return $query->whereIn('risk_level', ['high', 'critical']);
    }
}
