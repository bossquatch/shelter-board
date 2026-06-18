<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class GuestBadge extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id', 'guest_stay_id', 'badge_uuid', 'badge_number', 'qr_payload',
        'issued_at', 'issued_by', 'printed_at', 'expires_at', 'revoked_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'printed_at' => 'datetime',
        'expires_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (GuestBadge $badge) {
            if (! $badge->badge_uuid) {
                $badge->badge_uuid = (string) Str::uuid();
            }

            if (! $badge->qr_payload) {
                $badge->qr_payload = $badge->badge_uuid;
            }
        });
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function guestStay(): BelongsTo
    {
        return $this->belongsTo(GuestStay::class);
    }

    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function scanEvents(): HasMany
    {
        return $this->hasMany(BadgeScanEvent::class);
    }

    public function getIsActiveAttribute(): bool
    {
        return is_null($this->revoked_at)
            && (is_null($this->expires_at) || $this->expires_at->isFuture());
    }
}
