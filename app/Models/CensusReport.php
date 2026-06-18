<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CensusReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'activation_shelter_id', 'reported_at', 'reported_by',
        'clients', 'caregivers', 'staff', 'pets', 'service_animals', 'notes',
        'webeoc_record_id', 'webeoc_synced_at', 'sync_status', 'sync_error',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'webeoc_synced_at' => 'datetime',
        'clients' => 'integer',
        'caregivers' => 'integer',
        'staff' => 'integer',
        'pets' => 'integer',
        'service_animals' => 'integer',
    ];

    public function activationShelter(): BelongsTo
    {
        return $this->belongsTo(ActivationShelter::class);
    }

    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function getTotalPeopleAttribute(): int
    {
        return $this->clients + $this->caregivers + $this->staff;
    }
}
