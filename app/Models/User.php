<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin_id',
        'phone',
        'profile_img',
        'banner_img',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'package_id',
        'volunteer_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the event registrations for the user.
     */
    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Get the events the user has registered for.
     */
    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'event_registrations')
                    ->withPivot(['status', 'registered_at'])
                    ->withTimestamps();
    }

    /**
     * Get the certificate requests for the user.
     */
    public function certificateRequests()
    {
        return $this->hasMany(CertificateRequest::class);
    }
    /**
     * Get the package associated with the user.
     */
    public function supportFeedback()
    {
        return $this->hasMany(SupportFeedback::class);
    }

    /**
     * Get the package purchases for the user.
     */
    public function packagePurchases()
    {
        return $this->hasMany(PackagePurchase::class);
    }

    /**
     * Get the donations for the user.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Generate a unique volunteer ID in format VWF_YY_0001
     */
    public static function generateVolunteerId()
    {
        $year = date('y'); // Get last 2 digits of current year
        $prefix = "VWF_{$year}_";
        
        // Get the last volunteer ID for this year
        $lastUser = self::where('volunteer_id', 'like', $prefix . '%')
            ->orderBy('volunteer_id', 'desc')
            ->first();
        
        if ($lastUser) {
            // Extract the number part and increment
            $lastNumber = (int) substr($lastUser->volunteer_id, -4);
            $newNumber = $lastNumber + 1;
        } else {
            // First volunteer of the year
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
