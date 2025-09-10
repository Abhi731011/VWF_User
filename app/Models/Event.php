<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'category_id',
        'tags',
        'banners',
        'event_date',
        'event_time',
        'venue',
        'location',
        'about_event',
        'agenda',
        'organizer_name',
        'contact_email',
        'contact_phone',
        'status',
        'is_featured',
        'visibility',
        'max_attendees',
        'registration_required',
        'registration_deadline',
        'documents',
        'speakers',
        'sponsors',
    ];

    protected $casts = [
        'tags' => 'array',
        'banners' => 'array',
        'documents' => 'array',
        'speakers' => 'array',
        'sponsors' => 'array',
        'is_featured' => 'boolean',
        'visibility' => 'boolean',
        'registration_required' => 'boolean',
        'event_date' => 'date',
        'registration_deadline' => 'date',
        'max_attendees' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the registrations for the event.
     */
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Get the registered users for the event.
     */
    public function registeredUsers()
    {
        return $this->belongsToMany(User::class, 'event_registrations')
                    ->withPivot(['status', 'registered_at'])
                    ->withTimestamps();
    }

    /**
     * Check if user is registered for this event.
     */
    public function isUserRegistered($userId)
    {
        return $this->registrations()->where('user_id', $userId)->exists();
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
