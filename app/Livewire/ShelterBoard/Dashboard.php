<?php

namespace App\Livewire\ShelterBoard;

use App\Models\Activation;
use App\Models\ActivationShelter;
use App\Models\OperationalLog;
use Livewire\Component;

class Dashboard extends Component
{
    public ?Activation $activation = null;

    public function mount(?int $activationId = null): void
    {
        $this->activation = $activationId
            ? Activation::find($activationId)
            : Activation::where('status', 'Active')->latest('started_at')->first()
                ?? Activation::latest()->first();
    }

    public function render()
    {
        $activationShelters = collect();
        $recentLogs = collect();

        if ($this->activation) {
            $activationShelters = ActivationShelter::with(['shelter', 'latestCensusReport'])
                ->where('activation_id', $this->activation->id)
                ->orderBy('status')
                ->get();

            $recentLogs = OperationalLog::with(['activationShelter.shelter', 'loggedBy'])
                ->whereHas('activationShelter', fn ($query) => $query->where('activation_id', $this->activation->id))
                ->latest('logged_at')
                ->limit(10)
                ->get();
        }

        $summary = [
            'total_shelters' => $activationShelters->count(),
            'open_shelters' => $activationShelters->whereIn('status', ['Open', 'At Capacity'])->count(),
            'capacity' => $activationShelters->sum('current_capacity'),
            'occupancy' => $activationShelters->sum(fn ($shelter) => $shelter->calculated_occupancy),
            'availability' => $activationShelters->sum(fn ($shelter) => $shelter->availability),
            'pets' => $activationShelters->sum(fn ($shelter) => $shelter->latestCensusReport?->pets ?? 0),
        ];

        return view('livewire.shelter-board.dashboard', compact('summary', 'activationShelters', 'recentLogs'));
    }
}
