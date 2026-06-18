<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'incident_type', 'status', 'started_at', 'ended_at', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function activationShelters(): HasMany
    {
        return $this->hasMany(ActivationShelter::class);
    }

    public function shelters()
    {
        return $this->belongsToMany(Shelter::class, 'activation_shelters')
            ->withPivot(['id', 'status', 'opened_at', 'closed_at', 'current_capacity', 'current_occupancy'])
            ->withTimestamps();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function getOpenSheltersCountAttribute(): int
    {
        return $this->activationShelters()->whereIn('status', ['Open', 'At Capacity'])->count();
    }

    public function getCurrentOccupancyAttribute(): int
    {
        return $this->activationShelters()->sum('current_occupancy');
    }
}
