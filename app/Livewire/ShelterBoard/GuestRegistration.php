<?php

namespace App\Livewire\ShelterBoard;

use App\Models\ActivationShelter;
use App\Models\Guest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class GuestRegistration extends Component
{
    use AuthorizesRequests;

    public ActivationShelter $activationShelter;

    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public ?string $date_of_birth = null;
    public string $address = '';
    public string $phone_primary = '';
    public string $phone_secondary = '';
    public string $email = '';
    public string $gender = '';
    public string $driver_license = '';
    public string $family_group_id = '';
    public bool $has_special_needs = false;
    public int $pet_count = 0;
    public string $pet_description = '';
    public string $notes = '';

    public function mount(ActivationShelter $activationShelter): void
    {
        $this->authorize('view', $activationShelter);
        $this->authorize('create', Guest::class);
        $this->activationShelter = $activationShelter->load(['activation', 'shelter']);
    }

    public function registerAndCheckIn()
    {
        $this->authorize('create', Guest::class);

        $this->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'nullable|date',
            'email' => 'nullable|email',
            'pet_count' => 'integer|min:0',
        ]);

        $guest = Guest::create([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name ?: null,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->date_of_birth,
            'address' => $this->address ?: null,
            'phone_primary' => $this->phone_primary ?: null,
            'phone_secondary' => $this->phone_secondary ?: null,
            'email' => $this->email ?: null,
            'gender' => $this->gender ?: null,
            'driver_license' => $this->driver_license ?: null,
            'family_group_id' => $this->family_group_id ?: null,
            'has_special_needs' => $this->has_special_needs,
            'notes' => $this->notes ?: null,
        ]);

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
            ->with('message', 'Guest registered and checked in.');
    }

    public function render()
    {
        return view('livewire.shelter-board.guest-registration');
    }
}
