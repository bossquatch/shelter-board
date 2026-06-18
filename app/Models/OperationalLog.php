<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperationalLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'activation_shelter_id', 'category', 'entry', 'logged_at', 'logged_by',
        'webeoc_record_id', 'webeoc_synced_at', 'sync_status', 'sync_error',
    ];

    protected $casts = [
        'logged_at' => 'datetime',
        'webeoc_synced_at' => 'datetime',
    ];

    public function activationShelter(): BelongsTo
    {
        return $this->belongsTo(ActivationShelter::class);
    }

    public function loggedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'logged_by');
    }

    public function scopeRecent($query)
    {
        return $query->orderByDesc('logged_at');
    }
}
