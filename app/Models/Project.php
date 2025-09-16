<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'category_id',
        'tags',
        'images',
        'video_url',
        'video_file',
        'target_amount',
        'min_donation',
        'end_date',
        'is_recurring',
        'organizer_name',
        'contact_email',
        'contact_phone',
        'status',
        'is_featured',
        'visibility',
        'location',
        'documents',
        'faqs',
        'updates',
    ];

    protected $casts = [
        'tags' => 'array',
        'images' => 'array',
        'documents' => 'array',
        'faqs' => 'array',
        'updates' => 'array',
        'is_featured' => 'boolean',
        'is_recurring' => 'boolean',
        'visibility' => 'boolean',
        'target_amount' => 'decimal:2',
        'min_donation' => 'decimal:2',
        'end_date' => 'date',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
