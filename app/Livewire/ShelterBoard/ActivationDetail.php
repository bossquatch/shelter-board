<?php

namespace App\Http\Livewire\ShelterBoard;

use App\Models\Activation;
use App\Models\ActivationShelter;
use App\Models\Shelter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ActivationDetail extends Component
{
    use AuthorizesRequests;

    public Activation $activation;
    public array $selectedShelters = [];

    public function mount(Activation $activation): void
    {
        $this->authorize('view', $activation);

        $this->activation = $activation;
        $this->selectedShelters = $activation->activationShelters()->pluck('shelter_id')->toArray();
    }

    public function saveShelters(): void
    {
        $this->authorize('update', $this->activation);

        foreach ($this->selectedShelters as $shelterId) {
            $shelter = Shelter::find($shelterId);

            if (! $shelter) {
                continue;
            }

            ActivationShelter::firstOrCreate(
                ['activation_id' => $this->activation->id, 'shelter_id' => $shelter->id],
                ['status' => 'Standby', 'current_capacity' => $shelter->capacity, 'current_occupancy' => 0]
            );
        }

        session()->flash('message', 'Activation shelters updated.');
    }

    public function render()
    {
        return view('livewire.shelter-board.activation-detail', [
            'shelters' => Shelter::active()->orderBy('name')->get(),
            'activationShelters' => $this->activation->activationShelters()->with('shelter')->orderBy('status')->get(),
            'canManageActivation' => auth()->user()->can('update', $this->activation),
        ]);
    }
}
