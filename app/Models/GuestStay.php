<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuestStay extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'activation_shelter_id', 'guest_id', 'status', 'checked_in_at', 'checked_in_by',
        'checked_out_at', 'checked_out_by', 'pet_count', 'pet_description',
        'badge_issued_at', 'badge_number', 'notes',
        'webeoc_record_id', 'webeoc_synced_at', 'sync_status', 'sync_error',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'badge_issued_at' => 'datetime',
        'webeoc_synced_at' => 'datetime',
        'pet_count' => 'integer',
    ];

    public function activationShelter(): BelongsTo
    {
        return $this->belongsTo(ActivationShelter::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function checkedInBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }

    public function checkedOutBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_out_by');
    }

    public function guestBadges(): HasMany
    {
        return $this->hasMany(GuestBadge::class);
    }

    public function badgeScanEvents(): HasMany
    {
        return $this->hasMany(BadgeScanEvent::class);
    }

    public function scopeCheckedIn($query)
    {
        return $query->whereNotNull('checked_in_at')->whereNull('checked_out_at');
    }

    public function checkIn(?User $user = null): bool
    {
        $this->status = 'Checked In';
        $this->checked_in_at = now();
        $this->checked_in_by = $user?->id;
        $saved = $this->save();

        $this->activationShelter?->operationalLogs()->create([
            'category' => 'General',
            'entry' => "{$this->guest->full_name} checked in.",
            'logged_at' => now(),
            'logged_by' => $user?->id,
        ]);

        return $saved;
    }

    public function checkOut(?User $user = null, ?string $notes = null): bool
    {
        $this->status = 'Checked Out';
        $this->checked_out_at = now();
        $this->checked_out_by = $user?->id;
        $this->notes = $notes ?? $this->notes;
        $saved = $this->save();

        $this->activationShelter?->operationalLogs()->create([
            'category' => 'General',
            'entry' => "{$this->guest->full_name} checked out.",
            'logged_at' => now(),
            'logged_by' => $user?->id,
        ]);

        return $saved;
    }
}
