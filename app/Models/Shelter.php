<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shelter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'address', 'municipality', 'county', 'region', 'postal_code',
        'latitude', 'longitude', 'capacity', 'special_needs_capacity', 'pet_capacity',
        'ada_compliant', 'pet_friendly', 'backup_generator', 'status', 'is_active', 'comments',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'capacity' => 'integer',
        'special_needs_capacity' => 'integer',
        'pet_capacity' => 'integer',
        'ada_compliant' => 'boolean',
        'pet_friendly' => 'boolean',
        'backup_generator' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function activationShelters(): HasMany
    {
        return $this->hasMany(ActivationShelter::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFullAddressAttribute(): string
    {
        return collect([$this->address, $this->municipality, $this->county, $this->postal_code])
            ->filter()
            ->implode(', ');
    }
}
