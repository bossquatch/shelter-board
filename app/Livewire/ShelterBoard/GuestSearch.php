<?php

namespace App\Livewire\ShelterBoard;

use App\Models\ActivationShelter;
use App\Models\Guest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class GuestSearch extends Component
{
    use AuthorizesRequests;

    public ActivationShelter $activationShelter;

    public string $search = '';
    public ?int $selectedGuestId = null;
    public int $pet_count = 0;
    public string $pet_description = '';
    public string $notes = '';

    public function mount(ActivationShelter $activationShelter): void
    {
        $this->authorize('view', $activationShelter);
        $this->authorize('create', Guest::class);

        $this->activationShelter = $activationShelter->load(['activation', 'shelter']);
    }

    public function selectGuest(int $guestId): void
    {
        $this->selectedGuestId = $guestId;
    }

    public function checkInExistingGuest()
    {
        $this->authorize('create', Guest::class);

        $this->validate([
            'selectedGuestId' => 'required|exists:guests,id',
            'pet_count' => 'integer|min:0',
        ]);

        $guest = Guest::findOrFail($this->selectedGuestId);

        $existingStay = $this->activationShelter->guestStays()
            ->where('guest_id', $guest->id)
            ->whereNull('checked_out_at')
            ->first();

        if ($existingStay) {
            session()->flash('error', 'This guest is already checked into this shelter.');
            return;
        }

        $stay = $this->activationShelter->guestStays()->create([
            'guest_id' => $guest->id,
            'status' => 'Registered',
            'pet_count' => $this->pet_count,
            'pet_description' => $this->pet_description ?: null,
            'notes' => $this->notes ?: null,
        ]);

        $stay->checkIn(auth()->user());

        return redirect()
            ->route('shelter-board.operations.show', $this->activationShelter)
            ->with('message', 'Existing guest checked in.');
    }

    public function render()
    {
        $guests = collect();

        if (strlen(trim($this->search)) >= 2) {
            $guests = Guest::search($this->search)
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->limit(20)
                ->get();
        }

        $selectedGuest = $this->selectedGuestId ? Guest::find($this->selectedGuestId) : null;

        return view('livewire.shelter-board.guest-search', [
            'guests' => $guests,
            'selectedGuest' => $selectedGuest,
        ]);
    }
}
