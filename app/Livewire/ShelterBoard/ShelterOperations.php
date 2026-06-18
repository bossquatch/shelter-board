<?php

namespace App\Http\Livewire\ShelterBoard;

use App\Models\ActivationShelter;
use App\Models\Guest;
use App\Models\GuestStay;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ShelterOperations extends Component
{
    use AuthorizesRequests;

    public ActivationShelter $activationShelter;
    public string $openingNotes = '';
    public string $closingNotes = '';
    public string $logCategory = 'General';
    public string $logEntry = '';
    public int $clients = 0;
    public int $caregivers = 0;
    public int $staff = 0;
    public int $pets = 0;
    public int $serviceAnimals = 0;
    public string $censusNotes = '';
    public string $guestSearch = '';

    public function mount(ActivationShelter $activationShelter): void
    {
        $this->authorize('view', $activationShelter);
        $this->activationShelter = $activationShelter->load(['activation', 'shelter']);
    }

    public function openShelter(): void
    {
        $this->authorize('open', $this->activationShelter);

        if ($this->activationShelter->opened_at) {
            session()->flash('error', 'Shelter has already been opened.');
            return;
        }

        $this->activationShelter->open(auth()->user(), $this->openingNotes);
        $this->activationShelter->refresh();
        session()->flash('message', 'Shelter opened.');
    }

    public function closeShelter(): void
    {
        $this->authorize('close', $this->activationShelter);

        if ($this->activationShelter->closed_at) {
            session()->flash('error', 'Shelter has already been closed.');
            return;
        }

        $this->activationShelter->close(auth()->user(), $this->closingNotes);
        $this->activationShelter->refresh();
        session()->flash('message', 'Shelter closed.');
    }

    public function submitCensus(): void
    {
        $this->authorize('submitCensus', $this->activationShelter);

        $this->validate([
            'clients' => 'integer|min:0',
            'caregivers' => 'integer|min:0',
            'staff' => 'integer|min:0',
            'pets' => 'integer|min:0',
            'serviceAnimals' => 'integer|min:0',
        ]);

        $this->activationShelter->censusReports()->create([
            'reported_at' => now(),
            'reported_by' => auth()->id(),
            'clients' => $this->clients,
            'caregivers' => $this->caregivers,
            'staff' => $this->staff,
            'pets' => $this->pets,
            'service_animals' => $this->serviceAnimals,
            'notes' => $this->censusNotes,
        ]);

        $this->activationShelter->operationalLogs()->create([
            'category' => 'General',
            'entry' => 'Census submitted.',
            'logged_at' => now(),
            'logged_by' => auth()->id(),
        ]);

        $this->reset('clients', 'caregivers', 'staff', 'pets', 'serviceAnimals', 'censusNotes');
        session()->flash('message', 'Census submitted.');
    }

    public function addLogEntry(): void
    {
        $this->authorize('addOperationalLog', $this->activationShelter);

        $this->validate([
            'logCategory' => 'required|string|max:100',
            'logEntry' => 'required|string',
        ]);

        $this->activationShelter->operationalLogs()->create([
            'category' => $this->logCategory,
            'entry' => $this->logEntry,
            'logged_at' => now(),
            'logged_by' => auth()->id(),
        ]);

        $this->reset('logEntry');
        session()->flash('message', 'Log entry added.');
    }

    public function checkOutGuest(int $guestStayId): void
    {
        $stay = GuestStay::where('activation_shelter_id', $this->activationShelter->id)->findOrFail($guestStayId);
        $this->authorize('checkOut', $stay);

        if ($stay->checked_out_at) {
            session()->flash('error', 'Guest has already checked out.');
            return;
        }

        $stay->checkOut(auth()->user());
        session()->flash('message', 'Guest checked out.');
    }

    public function render()
    {
        $this->activationShelter->refresh();

        $guestStays = $this->activationShelter->guestStays()
            ->with('guest')
            ->when($this->guestSearch, fn ($query) => $query->whereHas('guest', fn ($guestQuery) => $guestQuery->search($this->guestSearch)))
            ->latest()
            ->get();

        return view('livewire.shelter-board.shelter-operations', [
            'guestStays' => $guestStays,
            'activeGuestStays' => $this->activationShelter->activeGuestStays()->with('guest')->get(),
            'recentLogs' => $this->activationShelter->operationalLogs()->with('loggedBy')->recent()->limit(10)->get(),
            'latestCensus' => $this->activationShelter->latestCensusReport,
            'canOpenShelter' => auth()->user()->can('open', $this->activationShelter),
            'canCloseShelter' => auth()->user()->can('close', $this->activationShelter),
            'canSubmitCensus' => auth()->user()->can('submitCensus', $this->activationShelter),
            'canAddOperationalLog' => auth()->user()->can('addOperationalLog', $this->activationShelter),
            'canRegisterGuests' => auth()->user()->can('create', Guest::class),
        ]);
    }
}
