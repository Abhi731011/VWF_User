<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateRequest extends Model
{
    protected $fillable = [
        'user_id',
        'request_id',
        'full_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'image_path',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the certificate request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a unique request ID in format VWF-YYYY-NNNN
     */
    public static function generateRequestId(): string
    {
        $currentYear = date('Y');
        $prefix = "VWF-{$currentYear}-";
        
        // Get the last request ID for this year
        $lastRequest = self::where('request_id', 'like', $prefix . '%')
            ->orderBy('request_id', 'desc')
            ->first();
        
        if ($lastRequest) {
            // Extract the number part and increment
            $lastNumber = (int) substr($lastRequest->request_id, -4);
            $newNumber = $lastNumber + 1;
        } else {
            // First request of the year
            $newNumber = 2001;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
