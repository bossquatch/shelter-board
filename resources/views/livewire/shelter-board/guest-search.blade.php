<div class="mx-auto max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold">Find Guest</h1>
        <p class="text-sm text-gray-600">
            {{ $activationShelter->shelter->name }} | {{ $activationShelter->activation->name }}
        </p>
    </div>

    @if(session()->has('error'))
        <div class="rounded bg-red-50 p-3 text-red-800">{{ session('error') }}</div>
    @endif

    <div class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-semibold">Search Before Registering</h2>

        <input
            wire:model.debounce.400ms="search"
            class="w-full rounded border p-3 text-lg"
            placeholder="Search by name, phone, or family group..."
            autofocus
        >

        <p class="mt-2 text-sm text-gray-500">
            Enter at least 2 characters before creating a new guest.
        </p>
    </div>

    <div class="rounded bg-white shadow">
        <div class="border-b p-4">
            <h2 class="font-semibold">Results</h2>
        </div>

        <div class="divide-y">
            @if(strlen(trim($search)) < 2)
                <div class="p-4 text-sm text-gray-500">Start typing to search.</div>
            @else
                @forelse($guests as $guest)
                    <div class="flex items-center justify-between p-4">
                        <div>
                            <div class="font-medium">{{ $guest->full_name }}</div>
                            <div class="text-sm text-gray-600">
                                DOB: {{ optional($guest->date_of_birth)->format('m/d/Y') ?? 'Unknown' }}
                                @if($guest->phone_primary)
                                    | Phone: {{ $guest->phone_primary }}
                                @endif
                                @if($guest->family_group_id)
                                    | Family: {{ $guest->family_group_id }}
                                @endif
                            </div>
                        </div>

                        <button wire:click="selectGuest({{ $guest->id }})"
                                class="rounded bg-gray-900 px-3 py-2 text-sm text-white">
                            Select
                        </button>
                    </div>
                @empty
                    <div class="p-4 text-sm text-gray-500">
                        No matching guests found.
                    </div>
                @endforelse
            @endif
        </div>
    </div>

    @if($selectedGuest)
        <div class="rounded bg-blue-50 p-4 shadow">
            <h2 class="mb-3 font-semibold">Selected Guest</h2>

            <div class="mb-3">
                <div class="font-medium">{{ $selectedGuest->full_name }}</div>
                <div class="text-sm text-gray-600">
                    DOB: {{ optional($selectedGuest->date_of_birth)->format('m/d/Y') ?? 'Unknown' }}
                    @if($selectedGuest->phone_primary)
                        | Phone: {{ $selectedGuest->phone_primary }}
                    @endif
                </div>
            </div>

            <div class="grid gap-3 md:grid-cols-2">
                <input type="number" min="0" wire:model="pet_count" class="rounded border p-2" placeholder="Pet Count">
                <input wire:model="pet_description" class="rounded border p-2" placeholder="Pet Description">
            </div>

            <textarea wire:model="notes" class="mt-3 w-full rounded border p-2" placeholder="Stay notes"></textarea>

            <div class="mt-4 flex justify-end gap-3">
                <button wire:click="$set('selectedGuestId', null)" class="rounded border px-4 py-2">
                    Cancel
                </button>

                <button wire:click="checkInExistingGuest" class="rounded bg-blue-700 px-4 py-2 text-white">
                    Check In Existing Guest
                </button>
            </div>
        </div>
    @endif

    <div class="flex justify-between">
        <a href="{{ route('shelter-board.operations.show', $activationShelter) }}" class="rounded border px-4 py-2">
            Back to Shelter
        </a>

        <a href="{{ route('shelter-board.guests.register', $activationShelter) }}" class="rounded bg-green-700 px-4 py-2 text-white">
            Register New Guest
        </a>
    </div>
</div>
