<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BadgeScanEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_badge_id', 'guest_stay_id', 'activation_shelter_id',
        'scan_type', 'scanned_at', 'scanned_by', 'device_id', 'notes',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function guestBadge(): BelongsTo
    {
        return $this->belongsTo(GuestBadge::class);
    }

    public function guestStay(): BelongsTo
    {
        return $this->belongsTo(GuestStay::class);
    }

    public function activationShelter(): BelongsTo
    {
        return $this->belongsTo(ActivationShelter::class);
    }

    public function scannedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }

    public function scopeForCensus($query)
    {
        return $query->where('scan_type', 'Census');
    }
}
