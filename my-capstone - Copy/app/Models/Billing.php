<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Billing extends Model
{
    protected $fillable = [
        'consultation_id',
        'receipt_number',
        'billing_date',
        'total_amount',
        'items',
        'payment_method',
        'payment_status',
        'is_waived',
        'waive_reason',
        'notes',
    ];

    protected $casts = [
        'billing_date' => 'date',
        'total_amount' => 'decimal:2',
        'items' => 'array',
    ];

    /**
     * Boot the model and add event listeners for audit logging.
     */
    protected static function booted()
    {
        static::created(function ($billing) {
            AuditLog::log(
                $billing,
                'created',
                'Billing invoice ' . $billing->receipt_number . ' generated for amount ' . $billing->getFormattedTotalAttribute(),
                null,
                $billing->toArray()
            );
        });

        static::updated(function ($billing) {
            $changes = $billing->getChanges();
            $original = $billing->getOriginal();
            
            unset($changes['updated_at'], $changes['created_at']);
            
            if (!empty($changes)) {
                $oldValues = array_intersect_key($original, $changes);
                
                AuditLog::log(
                    $billing,
                    'updated',
                    'Billing invoice ' . $billing->receipt_number . ' updated',
                    $oldValues,
                    $changes
                );
            }
        });

        static::deleted(function ($billing) {
            AuditLog::log(
                $billing,
                'deleted',
                'Billing invoice ' . $billing->receipt_number . ' deleted'
            );
        });
    }

    /**
     * Relationship: Billing belongs to Consultation
     */
    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }

    /**
     * Generate a unique receipt number
     * Format: REC-YYYY-####
     */
    public static function generateReceiptNumber(): string
    {
        $year = now()->year;
        $prefix = "REC-{$year}-";

        // Get the last receipt number for this year
        $lastBilling = self::where('receipt_number', 'like', "{$prefix}%")
            ->orderBy('receipt_number', 'desc')
            ->first();

        if ($lastBilling) {
            // Extract the number part and increment
            $lastNumber = (int) substr($lastBilling->receipt_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            // First receipt of the year
            $newNumber = 1;
        }

        // Format with leading zeros (4 digits)
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get consultation fee based on appointment type
     * All appointment types (in-clinic, online, walk-in, follow-up) use the same fee
     */
    public static function getConsultationFee(Consultation $consultation): float
    {
        return 500.00; // Standard consultation fee for all types
    }

    /**
     * Check if payment is fully paid
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Check if payment is partial
     */
    public function isPartial(): bool
    {
        return $this->payment_status === 'partial';
    }

    /**
     * Check if payment is waived
     */
    public function isWaived(): bool
    {
        return $this->is_waived || $this->payment_status === 'waived';
    }

    /**
     * Get waive reason label
     */
    public function getWaiveReasonLabel(): string
    {
        $reasons = [
            'family_member' => 'Family Member',
            'pro_bono' => 'Pro Bono Service',
            'staff_dependent' => 'Staff/Dependent',
            'charity_case' => 'Charity Case',
            'other' => 'Other',
        ];

        return $reasons[$this->waive_reason] ?? $this->waive_reason;
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAttribute(): string
    {
        return '₱' . number_format($this->total_amount, 2);
    }

    /**
     * Get formatted billing date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->billing_date->format('M d, Y');
    }
}
