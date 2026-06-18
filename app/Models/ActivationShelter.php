<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivationShelter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'activation_id', 'shelter_id', 'status', 'opened_at', 'opened_by',
        'closed_at', 'closed_by', 'current_capacity', 'current_occupancy', 'notes',
        'webeoc_record_id', 'webeoc_synced_at', 'sync_status', 'sync_error',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'webeoc_synced_at' => 'datetime',
        'current_capacity' => 'integer',
        'current_occupancy' => 'integer',
    ];

    public function activation(): BelongsTo
    {
        return $this->belongsTo(Activation::class);
    }

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class);
    }

    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function guestStays(): HasMany
    {
        return $this->hasMany(GuestStay::class);
    }

    public function activeGuestStays(): HasMany
    {
        return $this->guestStays()
            ->whereNotNull('checked_in_at')
            ->whereNull('checked_out_at');
    }

    public function censusReports(): HasMany
    {
        return $this->hasMany(CensusReport::class);
    }

    public function operationalLogs(): HasMany
    {
        return $this->hasMany(OperationalLog::class);
    }

    public function badgeScanEvents(): HasMany
    {
        return $this->hasMany(BadgeScanEvent::class);
    }

    public function latestCensusReport()
    {
        return $this->hasOne(CensusReport::class)->latestOfMany('reported_at');
    }

    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['Open', 'At Capacity']);
    }

    public function getCalculatedOccupancyAttribute(): int
    {
        return $this->activeGuestStays()->count();
    }

    public function getAvailabilityAttribute(): int
    {
        return max(($this->current_capacity ?? 0) - $this->calculated_occupancy, 0);
    }

    public function open(?User $user = null, ?string $notes = null): bool
    {
        $this->status = 'Open';
        $this->opened_at = now();
        $this->opened_by = $user?->id;
        $this->notes = $notes ?? $this->notes;
        $this->current_capacity = $this->current_capacity ?: ($this->shelter->capacity ?? 0);
        $saved = $this->save();

        $this->operationalLogs()->create([
            'category' => 'General',
            'entry' => 'Shelter opened.',
            'logged_at' => now(),
            'logged_by' => $user?->id,
        ]);

        return $saved;
    }

    public function close(?User $user = null, ?string $notes = null): bool
    {
        $this->status = 'Closed';
        $this->closed_at = now();
        $this->closed_by = $user?->id;
        $this->notes = $notes ?? $this->notes;
        $saved = $this->save();

        $this->operationalLogs()->create([
            'category' => 'General',
            'entry' => 'Shelter closed.',
            'logged_at' => now(),
            'logged_by' => $user?->id,
        ]);

        return $saved;
    }
}
