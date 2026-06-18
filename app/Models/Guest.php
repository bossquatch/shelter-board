<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'date_of_birth', 'address',
        'phone_primary', 'phone_secondary', 'email', 'gender', 'driver_license',
        'family_group_id', 'has_special_needs', 'profile_photo_path', 'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'has_special_needs' => 'boolean',
    ];

    public function guestStays(): HasMany
    {
        return $this->hasMany(GuestStay::class);
    }

    public function guestBadges(): HasMany
    {
        return $this->hasMany(GuestBadge::class);
    }

    public function currentStay()
    {
        return $this->hasOne(GuestStay::class)
            ->whereNotNull('checked_in_at')
            ->whereNull('checked_out_at')
            ->latestOfMany('checked_in_at');
    }

    public function getFullNameAttribute(): string
    {
        return collect([$this->first_name, $this->middle_name, $this->last_name])
            ->filter()
            ->implode(' ');
    }

    public function scopeSearch($query, ?string $term)
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function ($query) use ($term) {
            $query->where('first_name', 'like', "%{$term}%")
                ->orWhere('last_name', 'like', "%{$term}%")
                ->orWhere('phone_primary', 'like', "%{$term}%")
                ->orWhere('phone_secondary', 'like', "%{$term}%")
                ->orWhere('family_group_id', 'like', "%{$term}%");
        });
    }
}
