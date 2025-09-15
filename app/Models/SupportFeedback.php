<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportFeedback extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'subject',
        'message',
        'priority',
        'category',
        'status',
        'admin_response',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the user that owns the support feedback.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the priority badge class.
     */
    public function getPriorityBadgeClass(): string
    {
        return match($this->priority) {
            'low' => 'badge bg-success',
            'medium' => 'badge bg-warning',
            'high' => 'badge bg-danger',
            'urgent' => 'badge bg-dark',
            default => 'badge bg-secondary',
        };
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'open' => 'badge bg-primary',
            'in_progress' => 'badge bg-warning',
            'resolved' => 'badge bg-success',
            'closed' => 'badge bg-secondary',
            default => 'badge bg-secondary',
        };
    }

    /**
     * Get the type badge class.
     */
    public function getTypeBadgeClass(): string
    {
        return match($this->type) {
            'support' => 'badge bg-info',
            'feedback' => 'badge bg-success',
            'bug_report' => 'badge bg-danger',
            'feature_request' => 'badge bg-warning',
            default => 'badge bg-secondary',
        };
    }
}
